<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ExportProductsToCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:products-to-csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export all products data to a CSV file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get all products with required columns
        $products = Product::select('name', 'base_price', 'discount_percentage', 'description', 'short_description')->get();

        // Define the CSV header
        $csvHeader = ['Tên sản phẩm', 'Giá gốc', 'Phần trăm giảm giá', 'Mô tả sản phẩm'];

        // Start building the CSV content
        $csvContent = [implode(',', $csvHeader)];

        foreach ($products as $product) {
            $combinedDescription = trim($product->description . ' ' . $product->short_description);

            $csvContent[] = implode(',', [
                $this->escapeCsvValue($product->name),
                $product->base_price,
                $product->discount_percentage,
                $this->escapeCsvValue($combinedDescription),
            ]);
        }

        // Convert the content to a string
        $csvString = implode("\n", $csvContent);

        // Add BOM to ensure UTF-8 encoding is recognized by Excel
        $csvStringWithBom = "\xEF\xBB\xBF" . $csvString;

        // Define the file name and save it to storage
        $fileName = 'products_export.csv';
        Storage::disk('public')->put($fileName, $csvStringWithBom);

        $this->info("Products exported successfully to storage/app/{$fileName}");

        return Command::SUCCESS;
    }

    /**
     * Escape CSV value to handle commas and special characters.
     *
     * @param string $value
     * @return string
     */
    private function escapeCsvValue($value)
    {
        $escapedValue = str_replace('"', '""', $value); // Escape double quotes
        return '"' . $escapedValue . '"';
    }
}
