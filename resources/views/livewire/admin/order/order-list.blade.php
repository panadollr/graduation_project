<div>
    <h4 class="card-title">Danh sách đơn hàng</h4>
    <br>

    <script src="https://cdn.lordicon.com/lordicon.js"></script>

        <div class="row">
            <!-- Total Orders -->
            <div class="col-md-2 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body p-3">
                        <h5 class="card-title">Tổng đơn hàng</h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-text fw-bold fs-4">{{ count($orders)}}</h6>
                        </div>
                        <div class="mt-3 text-center">
                            <!-- Truck icon for delivery + Times-circle icon for cancellation -->
                            <i class="fa fa-cube text-primary" style="font-size: 40px;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body p-3">
                        <h5 class="card-title">Đang chờ xác nhận</h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-text fw-bold fs-4">{{ $orderStatistics['pending'] }}</h6>
                        </div>
                        <div class="mt-3 text-center">
                            <!-- Truck icon for delivery + Times-circle icon for cancellation -->
                            <i class="fa fa-hourglass-half text-primary" style="font-size: 40px;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body p-3">
                        <h5 class="card-title">Đang giao hàng</h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-text fw-bold fs-4">{{ $orderStatistics['shipped'] }}</h6>
                        </div>
                        <div class="mt-3 text-center">
                            <i class="fa fa-truck text-primary" style="font-size: 40px;"></i>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Fulfilled Orders -->
            <div class="col-md-2 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body p-3">
                        <h5 class="card-title">Đã giao hàng</h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-text fw-bold fs-4">{{ $orderStatistics['completed'] }}</h6>
                        </div>
                        <div class="mt-3 text-center">
                            <i class="fa fa-check-circle text-success" style="font-size: 40px;"></i>
                        </div>
                        
                    </div>
                </div>
            </div>

            <!-- Returns Orders -->
            <div class="col-md-2 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body p-3">
                        <h5 class="card-title">Đã hủy</h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-text fw-bold fs-4">{{ $orderStatistics['cancelled'] }}</h6>
                        </div>
                        <div class="mt-3 text-center">
                            <!-- Truck icon for delivery + Times-circle icon for cancellation -->
                            <i class="fa fa-times-circle text-danger" style="font-size: 40px;"></i>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

      <div class="row">                 
        <div class="col-lg-12 ">
          <div class="card">
            <div class="card-body">
            <nav class="navbar navbar-expand-lg border border-2">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item me-4">
                                <x-admin.filter-dropdown
                                    :items="$statuses" 
                                    label="Trạng thái đơn hàng"
                                    selectedLabel=" {{ $filterStatus ? $statuses[$filterStatus] : 'Tất cả' }}" 
                                    clickAction="filterByStatus" 
                                />
                            </li>
                           
                        </ul>
                        <form class="d-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                                <x-admin.input.text style="width: 400px" wire:model.live="search" placeholder="Tìm kiếm theo tên khách hàng, mã đơn hàng..."/>
                              </div>
                        </form>
                    </div>
                </div>
              </nav>
   
    <!-- List -->
    <x-admin.table>
        <x-slot name="head">
            <x-admin.table.heading
                sortable
                onSort="sortBy('id')" 
                direction="{{ $sortField === 'id' ? $sortDirection : 'desc' }}">
                #
            </x-admin.table.heading>
            <x-admin.table.heading>Người mua</x-admin.table.heading>
            <x-admin.table.heading>Tình trạng</x-admin.table.heading>
            <x-admin.table.heading
                sortable
                onSort="sortBy('total_price')" 
                direction="{{ $sortField === 'total_price' ? $sortDirection : 'desc' }}">
                Tổng tiền
            </x-admin.table.heading>
            <x-admin.table.heading 
                sortable
                onSort="sortBy('created_at')" 
                direction="{{ $sortField === 'created_at' ? $sortDirection : 'desc' }}">
                Ngày đặt hàng
            </x-admin.table.heading>
            <x-admin.table.heading>Xử lý đơn</x-admin.table.heading>
            <x-admin.table.heading>Hành động</x-admin.table.heading>
        </x-slot>

        <x-slot name="body">
            @forelse($orders as $order)
            <x-admin.table.row wire:loading.class="opacity-50">
                <x-admin.table.cell style="font-weight:bold">
                    {{ $order->id }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    <h6>{{ $order->userAddress->name }}</h6>
                    <p>{{ $order->user->email }}</p>
                </x-admin.table.cell>
                <x-admin.table.cell>
                    @php
                        $badgeClass = '';
                        $badgeText = $order->getStatusString();
                        if ($order->status == 'pending') {
                            $badgeClass = 'badge-opacity-warning'; 
                        } elseif ($order->status == 'shipped') {
                            $badgeClass = 'badge-opacity-info';
                        } elseif ($order->status == 'completed') {
                            $badgeClass = 'badge-opacity-success'; 
                        } elseif ($order->status == 'cancelled') {
                            $badgeClass = 'badge-opacity-danger'; 
                        }
                    @endphp
                    <label class="badge {{ $badgeClass }}" style="font-weight: bold">
                        {{ $badgeText }}
                    </label>
                </x-admin.table.cell>
                <x-admin.table.cell>
                    <h6 style="font-weight: bold">{{ formatVND($order->total_price) }}</h6>
                </x-admin.table.cell>
                <x-admin.table.cell>
                    {{ $order->created_at }}
                </x-admin.table.cell>
                <x-admin.table.cell>  

        <div style="display: flex; flex-direction: column; gap: 10px;">
            @if($order->status == 'pending')
                <button wire:click="confirmAction('{{ $order->id }}', 'cancelled')" 
                    type="button" style="font-weight: bold"
                    class="btn btn-danger btn-rounded btn-icon-text btn-sm">
                    Hủy đơn
                    <i class="ti-close btn-icon-append"></i>
                </button>
                <button wire:click="confirmAction('{{ $order->id }}', 'shipped')" 
                        type="button" style="font-weight: bold"
                        class="btn btn-success btn-rounded btn-icon-text btn-sm">
                    Duyệt đơn
                    <i class="ti-check btn-icon-append"></i>
                </button>

            @elseif($order->status == 'shipped')
                <button wire:click="updateOrderStatus('{{ $order->id }}', 'completed')" 
                        type="button" style="font-weight: bold"
                        class="btn btn-success btn-rounded btn-icon-text btn-sm">
                        Xác nhận đã giao hàng
                    <i class="ti-truck btn-icon-append"></i>
                </button>
            @endif
        </div>

                </x-admin.table.cell>
                <x-admin.table.cell>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <a wire:navigate href="{{ route('admin.order.detail', ['id' => $order->id ]) }}" 
                           type="button" style="font-weight: bold"
                           class="btn btn-info btn-rounded btn-icon-text btn-sm">
                            Xem chi tiết
                            <i class="ti-eye btn-icon-append"></i>
                        </a>
                        
                        @if($order->status == 'cancelled')
                        <button type="button" style="font-weight: bold"
                                class="btn btn-danger btn-rounded btn-icon-text btn-sm"
                                @click=" confirm('Bạn chắc chắn muốn xóa đơn hàng này?') ? $wire.deleteOrder({{ $order->id }}) : false">
                            Xóa 
                            <i class="ti-trash btn-icon-append"></i>
                        </button>
                        @endif
                    </div>
                </x-admin.table.cell>
                
            </x-admin.table.row>
            @empty
            <x-admin.table.row>
                <x-admin.table.cell colspan="8" class="text-center">Không có đơn hàng nào</x-admin.table.cell>
            </x-admin.table.row>
            @endforelse
        </x-slot>
    </x-admin.table>
    
    <br>
    <!-- Pagination - Always Visible -->
    {{ $orders->links() }}

    <!-- Modal xác nhận -->
    @if($showConfirmModal)
    <div x-data="{ open: @entangle('showConfirmModal') }" x-show="open" @click.away="open = false"  style="display: none;">
        <x-modal wire:model="showConfirmModal">
            <x-slot name="title">Xác nhận hành động</x-slot>
            <div class="card-body">
                <h5 class="text-center">{{ $confirmationMessage }}</h5>
            </div>
            <x-slot name="footer">
                <button type="button" @click="open = false" class="btn btn-light">Đóng</button>
                <button style="margin-left: 10px" type="submit" wire:click="performAction" class="btn btn-primary me-2">Xác nhận</button>
            </x-slot>
        </x-modal>
    </div>
    @endif

            </div>
          </div>
      </div>

</div> 
</div>
