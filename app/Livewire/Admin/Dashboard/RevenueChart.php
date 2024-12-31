<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Order;
use Carbon\Carbon;
use Livewire\Component;

class RevenueChart extends Component
{
    public $timeRange = 'week'; // Mặc định là theo tháng
    public $revenue = 0; // Tổng doanh thu
    public $growth = 0; // Tỷ lệ tăng trưởng
    public $labels = []; // Nhãn biểu đồ
    public $data = []; // Dữ liệu biểu đồ

    public function mount()
    {
        $this->loadData();
    }

    public function updatedTimeRange()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $now = Carbon::now();
        $query = Order::where('status', 'completed'); // Chỉ lấy đơn hàng hoàn thành

        if ($this->timeRange === 'day') {
            // Doanh thu theo từng giờ trong ngày
            $this->labels = range(0, 23); // 0 -> 23 giờ
            $query->whereDate('created_at', $now);

            $revenues = $query->selectRaw('HOUR(created_at) as hour, SUM(total_price) as revenue')
                              ->groupBy('hour')
                              ->pluck('revenue', 'hour')
                              ->toArray();

            $this->data = array_map(fn($hour) => $revenues[$hour] ?? 0, $this->labels);
        } elseif ($this->timeRange === 'week') {
            $this->labels = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'];
            $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);

            $revenues = $query->selectRaw('DAYOFWEEK(created_at) as day, SUM(total_price) as revenue')
                            ->groupBy('day')
                            ->pluck('revenue', 'day')
                            ->toArray();

            $this->data = [
                $revenues[2] ?? 0, // Thứ 2
                $revenues[3] ?? 0, // Thứ 3
                $revenues[4] ?? 0, // Thứ 4
                $revenues[5] ?? 0, // Thứ 5
                $revenues[6] ?? 0, // Thứ 6
                $revenues[7] ?? 0, // Thứ 7
                $revenues[1] ?? 0, // Chủ nhật
            ];
        } else {
            // Doanh thu theo từng ngày trong tháng
            $this->labels = collect(range(1, $now->daysInMonth))->toArray();
            $query->whereMonth('created_at', $now->month)
                  ->whereYear('created_at', $now->year);

            $revenues = $query->selectRaw('DAY(created_at) as day, SUM(total_price) as revenue')
                              ->groupBy('day')
                              ->pluck('revenue', 'day')
                              ->toArray();

            $this->data = array_map(fn($day) => $revenues[$day] ?? 0, $this->labels);
        }

        // Tổng doanh thu
        $this->revenue = array_sum($this->data);

        // Tính tăng trưởng
        $this->growth = $this->calculateGrowth();

        $this->js("createChart(". json_encode($this->labels) .", ".json_encode($this->data).")");
    }

    private function calculateGrowth()
    {
        $now = Carbon::now();
        $lastPeriodQuery = Order::where('status', 'completed'); // Chỉ tính đơn hoàn thành

        if ($this->timeRange === 'day') {
            $lastPeriodQuery->whereDate('created_at', $now->subDay());
        } elseif ($this->timeRange === 'week') {
            $lastPeriodQuery->whereBetween('created_at', [$now->subWeek()->startOfWeek(), $now->subWeek()->endOfWeek()]);
        } else {
            $lastPeriodQuery->whereMonth('created_at', $now->subMonth()->month)
                            ->whereYear('created_at', $now->year);
        }

        $lastRevenue = $lastPeriodQuery->sum('total_price');

        return $lastRevenue ? (($this->revenue - $lastRevenue) / $lastRevenue) * 100 : 0;
    }

    public function render()
    {
        return view('livewire.admin.dashboard.revenue-chart');
    }
}
