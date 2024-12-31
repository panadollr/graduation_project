<div>
    <h4 class="card-title">Danh sách đơn hàng</h4>
    <br>
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
            <x-admin.table.heading>Tên khách hàng</x-admin.table.heading>
            <x-admin.table.heading>Email</x-admin.table.heading>
            <x-admin.table.heading>Tình trạng</x-admin.table.heading>
            <x-admin.table.heading>Tổng tiền</x-admin.table.heading>
            <x-admin.table.heading 
                sortable
                onSort="sortBy('created_at')" 
                direction="{{ $sortField === 'created_at' ? $sortDirection : 'desc' }}">
                Ngày đặt hàng
            </x-admin.table.heading>
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
                </x-admin.table.cell>
                <x-admin.table.cell>{{ $order->user->email }}</x-admin.table.cell>
                <x-admin.table.cell>
                    @php
                        $badgeClass = '';
                        $badgeText = $order->getStatusString($order->status);
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
                <x-admin.table.cell>{{ formatVND($order->total_price) }}</x-admin.table.cell>
                <x-admin.table.cell>
                    {{ $order->created_at }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    @php
                        $nextAction = $this->getNextStatus($order->status);
                    @endphp                
                    @if ($nextAction)
                        <button wire:click="updateOrderStatus('{{ $order->id }}', '{{ $nextAction['status'] }}')" 
                                type="button" 
                                class="btn btn-{{ $nextAction['color'] }} btn-rounded btn-icon-text btn-sm">
                            {{ $nextAction['label'] }}
                            <i class="ti-arrow-right btn-icon-append"></i>
                        </button>
                    @endif
                    
                    <button wire:click="showOrderDetail({{ $order->id }})" type="button" class="btn btn-info btn-rounded btn-icon-text btn-sm">
                        Xem chi tiết
                        <i class="ti-eye btn-icon-append"></i>
                    </button>
                    @if($order->status == 'cancelled')
                    <button type="button" class="btn btn-danger btn-rounded btn-icon-text btn-sm"
                    @click=" confirm('Bạn chắc chắn muốn xóa đơn hàng này?') ? $wire.deleteOrder({{ $order->id }}) : false">
                        Xóa 
                        <i class="ti-trash btn-icon-append"></i>
                    </button>
                    @endif
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

    @if($showOrderModal)
    <div x-data="{ open: @entangle('showOrderModal') }" 
    x-show="open" 
    @click.away="open = false" 
    class="modal-container">
   <x-modal wire:model="showOrderModal">
        <x-slot name="title">Chi tiết đơn hàng</x-slot>
       <div class="card-body">
        <div class="card p-3 border">
            <div class="d-flex align-items-center mb-3">
                <i class="fa fa-user-o text-primary me-2 fs-6"></i>
                    <strong class="text-primary">Tên người nhận:</strong>
                    <span class="mb-0 fs-8"> {{ $selectedOrder->userAddress->name }}</span>
            </div>
            <div class="d-flex align-items-center mb-3">
                <i class="fa fa-envelope text-primary me-2 fs-6"></i>
                    <strong class="text-primary">Email:</strong>
                    <span class="mb-0 fs-8">{{ $selectedOrder->user->email }}</span>
            </div>
            <div class="d-flex align-items-center mb-3">
                <i class="fa fa-phone text-success me-2 fs-5"></i>
                <div>
                    <strong class="text-primary">Số điện thoại:</strong>
                    <span class="mb-0 fs-7">{{ $selectedOrder->userAddress->phone }}</span>
                </div>
            </div>
            <div class="d-flex align-items-center mb-3">
                <i class="fa fa-map-marker text-danger me-2 fs-4"></i>
                <div>
                    <strong class="text-primary">Địa chỉ giao hàng:</strong>
                    <span class="mb-0 fs-6">{{ $selectedOrder->userAddress->address }}</span>
                </div>
            </div>
            <div class="d-flex align-items-center mb-3">
                <i class="fa fa-university text-warning me-2 fs-6"></i>
                <div>
                    <strong class="text-primary">Phương thức thanh toán:</strong>
                    <span class="mb-0 fs-6" style="text-decoration: underline;">Thanh toán khi nhận hàng</span>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <i class="fa fa-archive text-info me-2 fs-6"></i>
                <div>
                    <strong class="text-primary">Phương thức vận chuyển:</strong>
                    <span class="mb-0 fs-6">{{ $selectedOrder->shippingMethod->name }} ({{ formatVND($selectedOrder->shippingMethod->price) }})</span>
                </div>
            </div>
        </div>
               
           <!-- Danh sách sản phẩm -->
           <h5 class="mt-4 fw-bold">Danh sách sản phẩm:</h5>
           <ul class="list-group mt-3">
               @foreach($selectedOrder->items as $item)
                   <li class="list-group-item d-flex align-items-center justify-content-between">
                       <div class="d-flex align-items-center">
                           <img src="{{ $item->product->featured_image }}" alt="{{ limitString($item->product->name, 10) }}" 
                                class="rounded" width="70" height="70" style="object-fit: cover; margin-right: 10px;">
                           <div>
                               <p class="fw-bold mb-0">{{ $item->product->name }}</p>
                               <p class="mb-0 text-muted">Giá: {{ formatVND($item->product->sale_price) }}</p>
                               <p class="mb-0 text-muted">Số lượng: {{ $item->quantity }}</p>
                           </div>
                       </div>
                       <p class="text-end fw-bold text-primary">
                          Thành tiền: {{ formatVND($item->product->sale_price * $item->quantity) }}
                       </p>
                   </li>
               @endforeach
           </ul>
           <hr>
           Tổng tiền: {{ formatVND($selectedOrder->total_price) }}
       </div>
       <x-slot name="footer">
           <button type="button" @click="open = false" class="btn btn-primary">Đóng</button>
       </x-slot>
   </x-modal>
</div>

@endif

@if($showStatusModal)
<div x-data="{ open: @entangle('showStatusModal') }" x-show="open" @click.away="open = false"  style="display: none;">
    <x-modal wire:model="showStatusModal">
        <x-slot name="title">Cập nhật trạng thái đơn hàng</x-slot>
        <div class="card-body">
            <form wire:submit.prevent="updateOrderStatus">
                <div class="form-group">
                    <label>Chọn trạng thái:</label>
                    <select wire:model="status" class="form-control">
                        <option value="pending">{{ $order->getStatusString('pending') }}</option>
                        <option value="shipped">{{ $order->getStatusString('shipped') }}</option>
                        <option value="completed">{{ $order->getStatusString('completed') }}</option>
                        <option value="cancelled">{{ $order->getStatusString('cancelled') }}</option>
                    </select>
                    @error('status') 
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </form>
        </div>
        <x-slot name="footer">
            <button type="submit" wire:click="updateOrderStatus" class="btn btn-primary me-2">Cập nhật</button>
            <button type="button" @click="open = false" class="btn btn-light">Hủy</button>
        </x-slot>
    </x-modal>
</div>
@endif

            </div>
          </div>
      </div>

      @json($orderStatistics['data'])
      <div class="col-lg-6 grid-margin stretch-card" style="margin-top: 20px">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Số lượng đơn hàng theo trạng thái</h4>
            <canvas id="barChart" wire:ignore></canvas>
          </div>
        </div>
      </div>

</div> 
      @section('script') 
      <script>
        let chart;
        function hh(){
        let data = {
          labels: @json($orderStatistics['labels']),
          datasets: [{
            label: 'Số lượng đơn hàng',
            data: @json($orderStatistics['data']),
            backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)', ],
            borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(153, 102, 255, 1)', 'rgba(75, 192, 192, 1)', 'rgba(255,99,132,1)', ],
            borderWidth: 1,
            fill: false
          }]
        };
        var options = {
          scales: {
            y: {
              ticks: {
                beginAtZero: true
              }
            }
          },
          legend: {
            display: false
          },
          elements: {
            line: {
              tension: 0.5
            },
            point: {
              radius: 0
            }
          }
        };
        
        if (chart) {
    chart.destroy();
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    chart =  new Chart(barChartCanvas, {
            type: 'bar',
            data: data,
            options: options
          });
  } else {
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    chart = new Chart(barChartCanvas, {
            type: 'bar',
            data: data,
            options: options
          });
  }
        }
      </script> @endsection
</div>
