<?php

namespace App\Livewire\Admin\Order;

use App\Models\Log;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Cache;

class OrderList extends Component
{
    use WithPagination;
    
    public $orderId;
    public $status;
    public $search = ''; 
    public $statuses = [
        'pending' => 'Đang chờ xác nhận',
        'shipped' => 'Đang giao hàng',
        'completed' => 'Đã giao hàng',
        'cancelled' => 'Đã hủy',
    ];
    public $filterStatus = null;
    public $sortField = 'created_at';
    public $sortDirection = 'desc'; 
    public $orderStatistics = [];

    public function mount()
    {
        $this->orderStatistics = $this->getOrderStatistics();
    }

    public function sortBy($field)
    {
        $this->sortDirection = ($this->sortField === $field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->sortField = $field;
    }

    public $orderIdToUpdate;
    public $actionToPerform;
    public $confirmationMessage;
    public $showConfirmModal  = false;

    public function confirmAction($orderId, $action)
    {
        $this->orderIdToUpdate = $orderId;
        $this->actionToPerform = $action;

        $this->confirmationMessage = match ($action) {
            'shipped' => 'Bạn chắc chắn muốn duyệt đơn này và tiến hành giao hàng chứ?',
            'cancelled' => 'Bạn chắc chắn muốn hủy đơn này?',
            default => '',
        };

        $this->showConfirmModal  = true;

    }

    public function performAction()
    {
        if ($this->orderIdToUpdate && $this->actionToPerform) {
            $this->updateOrderStatus($this->orderIdToUpdate, $this->actionToPerform);
        }
    }

    // Cập nhật trạng thái đơn hàng
    public function updateOrderStatus($orderId, $status)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->updateStatus($status);
            $this->orderStatistics = $this->getOrderStatistics();
            $this->js('showToast("Đã cập nhật trạng thái đơn hàng!", "success")');
            $this->showConfirmModal = false; 
        }
    }

    public function filterByStatus($status = null)
    {
        $this->filterStatus = $status;
        $this->resetPage(); // Reset về trang đầu tiên khi áp dụng bộ lọc
    }

    public function deleteOrder($id)
    {
        $order = Order::find($id);
        if ($order) {
            // Xóa lịch sử trạng thái đơn hàng
            OrderStatusHistory::where('order_id', $order->id)->delete();

            // Xóa đơn hàng
            $order->delete();
            $this->js('showToast("Đơn hàng đã được xóa thành công.", "success")');
        }
    }

    public function getOrderStatistics()
    {
        $defaultStatus = ['pending' => 0, 'shipped' => 0, 'completed' => 0, 'cancelled' => 0];
        $statistics = Order::selectRaw('status, COUNT(id) as count')
        ->groupBy('status')
        ->get();

        foreach ($statistics as $item) {
            // Kiểm tra nếu trạng thái có trong mảng mặc định
            if (array_key_exists($item->status, $defaultStatus)) {
                $defaultStatus[$item->status] = $item->count;
            }
        }

        $defaultStatus['all'] = Order::count();
        return $defaultStatus;
    }

    public function render()
    {
        $orders = Order::query()
            ->with(['user', 'userAddress', 'shippingMethod', 'items.product'])
            ->where(function ($query) {
                $query->where('id', 'like', '%' . $this->search . '%')
                      ->orWhereHas('userAddress', function ($userQuery) {
                          $userQuery->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->filterStatus, fn ($query) => $query->where('status', $this->filterStatus))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.order.order-list', compact('orders'))
        ->extends('admin.app')
        ->section('content')
        ->layoutData(['title' => 'Quản lý đơn hàng']);
    }
}
