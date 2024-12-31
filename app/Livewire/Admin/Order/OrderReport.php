<?php

namespace App\Livewire\Admin\Order;

use App\Models\Order;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;

class OrderReport extends Component
{
    use WithPagination;

    public $startDateOfStatisticsByDateRange;
    public $endDateOfStatisticsByDateRange;
    public $statisticsByDateRange = [];

    public $startDate;
    public $endDate;
    public $revenueStatistics = [];

    public function mount()
    {
        $this->startDateOfStatisticsByDateRange = Carbon::now()->startOfMonth()->format('Y-m-d'); // Ví dụ: ngày đầu tháng hiện tại
        $this->endDateOfStatisticsByDateRange = Carbon::now()->endOfDay()->format('Y-m-d');
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d'); // Ví dụ: ngày đầu tháng hiện tại
        $this->endDate = Carbon::now()->endOfDay()->format('Y-m-d');
        
        $this->updateDateRangeChart();
        $this->revenueStatistics = $this->getRevenueStatistics();
    }

    public function getStatisticsByDateRange($startDate, $endDate)
    {
        $data = Order::selectRaw('
                DATE(orders.created_at) as date, 
                COUNT(orders.id) as order_count, 
                SUM(order_items.quantity) as total_quantity_sold
                ')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get() 
            ->keyBy('date');

        return [
            'labels' => $data->keys()->toArray(),
            'orders' => $data->pluck('order_count')->map(fn($value) => (int)$value)->toArray(),
            'product_quantities' => $data->pluck('total_quantity_sold')->map(fn($value) => (int)$value)->toArray(),
        ];
    }

    public function updateDateRangeChart()
    {
        $this->statisticsByDateRange = $this->getStatisticsByDateRange($this->startDateOfStatisticsByDateRange, $this->endDateOfStatisticsByDateRange);

        $this->js(sprintf(
            'renderDateRangeChart(%s, %s, %s)',
            json_encode($this->statisticsByDateRange['labels']),
            json_encode($this->statisticsByDateRange['product_quantities']),
            json_encode($this->statisticsByDateRange['orders'])
        ));
    }

    public function getRevenueStatistics()
    {
        $ordersQuery = Order::whereBetween('created_at', [$this->startDate, $this->endDate])->where('status', 'completed');

        return [
            'totalRevenue' => $ordersQuery->sum('total_price'), // Tổng doanh thu
            'totalOrders' => $ordersQuery->count(), // Tổng số đơn
        ];
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['startDateOfStatisticsByDateRange', 'endDateOfStatisticsByDateRange'])) {
            $this->updateDateRangeChart();
        }

        if (in_array($propertyName, ['startDate', 'endDate'])) {
            $this->revenueStatistics = $this->getRevenueStatistics();
        }
    }

    public function render()
    {
        $orders = Order::whereBetween('created_at', [$this->startDate, $this->endDate])->where('status', 'completed')->paginate(10);
        
        return view('livewire.admin.order.order-report', compact('orders'))
        ->extends('admin.app')
        ->layoutData(['title' => 'Báo cáo và thống kê']);
    }
}
