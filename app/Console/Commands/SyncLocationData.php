<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class SyncLocationData extends Command
{
    protected $signature = 'sync:locations';
    protected $description = 'Sync locations (cities, districts, wards) from API into the settings table';

    public function handle()
    {
        // Fetch and store cities
        $this->info("Fetching cities...");
        $cities = $this->fetchData('https://esgoo.net/api-tinhthanh/1/0.htm');
        if ($cities) {
            $this->saveDataToSettings('cities', $cities);
        }

        // Fetch and store districts
        foreach ($cities as $city) {
            $this->info("Fetching districts for city: {$city['name']}...");
            $districts = $this->fetchData("https://esgoo.net/api-tinhthanh/2/{$city['id']}.htm");
            if ($districts) {
                $this->saveDataToSettings('districts', $districts, $city['id']);
            }

            // Fetch and store wards
            foreach ($districts as $district) {
                $this->info("Fetching wards for district: {$district['name']}...");
                $wards = $this->fetchData("https://esgoo.net/api-tinhthanh/3/{$district['id']}.htm");
                if ($wards) {
                    $this->saveDataToSettings('wards', $wards, $district['id']);
                }
            }
        }

        $this->info("Sync completed successfully!");
    }

    private function fetchData($url)
    {
        $response = Http::get($url);
        if ($response->successful()) {
            $data = $response->json();
            if ($data['error'] === 0) {
                return $data['data'];
            }
        }

        $this->error("Failed to fetch data from {$url}");
        return null;
    }

    private function saveDataToSettings($type, $data, $parentId = null)
    {
        $entries = [];
        foreach ($data as $item) {
            $entries[] = [
                'key' => $type,
                'name' => $item['name'], // Display name
                'value' => json_encode([
                    'id' => $item['id'],
                    'parent_id' => $parentId,
                ]), // Storing ID and parent_id as JSON
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('settings')->insert($entries);

        $this->info("Saved " . count($entries) . " {$type} to settings.");
    }
}
