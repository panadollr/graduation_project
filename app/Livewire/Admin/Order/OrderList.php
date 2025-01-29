<?php

namespace App\Livewire\Admin\Order;

use App\Models\Log;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\Setting;
use App\Models\ShippingMethod;
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

    public $orderDateFrom;
    public $orderDateTo;
    public $paymentMethod;
    public $shippingAddress;
    public $shippingMethods;
    public $shippingMethod;

    public $selectedCity = null;
    public $selectedDistrict = null;
    public $selectedWard = null;
    public $cities = [];
    public $districts = [];
    public $wards = [];

    public function mount()
    {
        $this->orderStatistics = $this->getOrderStatistics();
        $this->shippingMethods = ShippingMethod::select(['id', 'name'])->get();
        $this->cities = Setting::where('key', 'cities')
        ->get()
        ->map(function ($item) {
            return [
                'id' => json_decode($item->value, true)['id'], // Lấy ID từ JSON trong cột `value`
                'name' => $item->name, // Lấy tên từ cột `name`
            ];
        })->pluck('name', 'id');    
    }

    public function updatedSelectedCity($cityId)
    {
        $this->districts = Setting::where('key', 'districts')
        ->whereJsonContains('value->parent_id', $cityId)
        ->get()
        ->map(function ($item) {
            return [
                'id' => json_decode($item->value, true)['id'], // Lấy ID từ JSON trong cột `value`
                'name' => $item->name, // Lấy tên từ cột `name`
            ];
        })
        ->pluck('name', 'id');
        $this->selectedDistrict = null;
        $this->wards = [];
    }

    public function updatedSelectedDistrict($districtId)
    {
        $this->wards = Setting::where('key', 'wards')
        ->whereJsonContains('value->parent_id', $districtId)
        ->get()
        ->map(function ($item) {
            return [
                'id' => json_decode($item->value, true)['id'], // Lấy ID từ JSON trong cột `value`
                'name' => $item->name, // Lấy tên từ cột `name`
            ];
        })
        ->pluck('name', 'id');
        $this->selectedWard = null;
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
            // Lọc theo ngày tạo đơn hàng
            ->when($this->orderDateFrom, fn ($query) => $query->whereDate('created_at', '>=', $this->orderDateFrom))
            ->when($this->orderDateTo, fn ($query) => $query->whereDate('created_at', '<=', $this->orderDateTo))
            // Lọc theo phương thức thanh toán
            ->when($this->paymentMethod, fn ($query) => $query->where('payment_method', $this->paymentMethod))
            // Lọc theo địa chỉ giao hàng
            ->when($this->shippingAddress, fn ($query) => $query->whereHas('userAddress', function ($userQuery) {
                $userQuery->where('address', 'like', '%' . $this->shippingAddress . '%');
            }))
            // Lọc theo phương thức vận chuyển
            ->when($this->shippingMethod, fn ($query) => $query->where('shipping_method_id', $this->shippingMethod))
            ->when($this->selectedCity, fn ($query) => $query->whereHas('userAddress', function ($userQuery) {
                $userQuery->where('city', $this->selectedCity);
            }))
            ->when($this->selectedDistrict, fn ($query) => $query->whereHas('userAddress', function ($userQuery) {
                $userQuery->where('district', $this->selectedDistrict);
            }))
            ->when($this->selectedWard, fn ($query) => $query->whereHas('userAddress', function ($userQuery) {
                $userQuery->where('ward', $this->selectedWard);
            }))
            ->orderByRaw("
                CASE 
                    WHEN status = 'pending' THEN 1
                    WHEN status = 'shipped' THEN 2
                    WHEN status = 'completed' THEN 3
                    WHEN status = 'canceled' THEN 4
                    ELSE 5
                END
            ")
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.order.order-list', compact('orders'))
        ->extends('admin.app')
        ->section('content')
        ->layoutData(['title' => 'Quản lý đơn hàng']);
    }
}
