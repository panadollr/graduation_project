<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Order;
use Carbon\Carbon;
use Livewire\Component;

class PerformanceChart extends Component
{
    public $labels = ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7']; // Các ngày trong tuần (tiếng Việt)
    public $dataThisWeek = [];
    public $dataLastWeek = [];

    public function mount()
    {
        $this->dataThisWeek = $this->getRevenueDataForWeek(Carbon::now());
        $this->dataLastWeek = $this->getRevenueDataForWeek(Carbon::now()->subWeek());
    }

    // Lấy doanh thu của tuần từ ngày hiện tại
    public function getRevenueDataForWeek($date)
    {
        $startOfWeek = $date->startOfWeek()->format('Y-m-d'); // Ngày bắt đầu tuần
        $endOfWeek = $date->endOfWeek()->format('Y-m-d'); // Ngày kết thúc tuần

        $revenues = [];
        for ($i = 0; $i < 7; $i++) {
            $day = Carbon::parse($startOfWeek)->addDays($i); // Tính từng ngày trong tuần
            $totalRevenue = Order::whereDate('created_at', $day)
                ->where('status', 'completed') // Nếu bạn chỉ muốn tính đơn hàng đã hoàn thành
                ->sum('total_price'); // Tổng doanh thu của ngày đó
            $revenues[] = $totalRevenue;
        }

        return $revenues;
    }

    public function render()
    {
        return view('livewire.admin.dashboard.performance-chart');
    }
}
