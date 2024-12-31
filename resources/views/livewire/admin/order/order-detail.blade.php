<div>
    @php
        function getBadgeClass($status) {
            switch ($status) {
                case 'pending':
                    return 'badge-opacity-warning';
                case 'shipped':
                    return 'badge-opacity-info';
                case 'completed':
                    return 'badge-opacity-success';
                case 'cancelled':
                    return 'badge-opacity-danger';
                default:
                    return '';
            }
        }
    @endphp
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.order.index') }}" class="btn btn-primary btn-sm me-3">
            <i class="fa fa-arrow-left me-1"></i> Danh sách đơn hàng
        </a>
    </div>

    <div class="d-flex align-items-center mb-3">
        <h3 class="mb-0">Mã đơn hàng: {{ $order->id }}</h3>
        <label class="badge {{ getBadgeClass($order->status) }} px-3 py-2" style="font-weight: bold; margin-left: 10px;">
                        {{ $order->getStatusString()}}
        </label>
    </div>

    <div class="row">
    <div class="col-md-7">
        <div class="card mb-3">
            <div class="card-body">
                <h4 class="card-title">Sản phẩm trong đơn hàng</h4>
                <!-- Order Item -->
                <div class="box">
                    @foreach($order->items as $item)
                    <div class="d-flex align-items-center p-1">
                        <img src="{{ $item->product->featured_image}}" class="me-3" style="width: 100px;padding: 5px;">
                        <div>
                            {{-- <h6>Laptop</h6> --}}
                            <h6 style="font-weight: bold">{{ $item->product->name}}</h6>
                            <span>{{ $item->quantity }} x {{ formatVND($item->product->sale_price) }}</span>
                            <strong>= {{ formatVND($item->quantity * $item->product->sale_price) }}</strong>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h4 class="card-title">Tổng quan đơn hàng</h4>
                <!-- Order Summary -->
                <div class="box">
                    <style>
                        .table td {
                            font-size: 15px
                        }
                    </style>
                    <table class="table table-striped">
                        <tr>
                            <td>Tạm tính</td>
                            <td class="text-end">{{ $order->items()->sum('quantity') }} sản phẩm</td>
                            <td class="text-end">{{ formatVND($order->items()->sum('price')) }}</td>
                        </tr>
                        <tr>
                            <td>Phí vận chuyển</td>
                            <td class="text-end">{{ $order->shippingMethod->name }}</td>
                            <td class="text-end">+ {{ formatVND($order->shippingMethod->price) }}</td>
                        </tr>
                        @if($order->discount)
                            <td>Mã giảm giá</td>
                            <td class="text-end">{{ $order->discount->code }}</td>
                            <td class="text-end"> - {{ formatVND(($order->items()->sum('price') + $order->shippingMethod->price) * ($order->discount->discount_value / 100)) }}</td>
                        @endif
                        <tr>
                            <td>Tổng cộng</td>
                            <td></td>
                            <td class="text-end fw-bold">{{ formatVND($order->total_price) }}</td>
                        </tr>
                        </table>
                        {{-- <button class="btn btn-outline-secondary btn-custom">Gửi hóa đơn</button>                    --}}
                </div> 
            </div>
        </div>


    </div>   

    <div class="col-md-5">
        <div class="card mb-3">
            <div class="card-body">
                <h4 class="card-title">Ghi chú đơn hàng</h4>
                <div class="box">
                    <div class="text-muted">{{ $order->note ?? 'Không có' }}</div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <h4 class="card-title">Khách hàng</h4>
                <div class="box">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-user-o text-primary me-2 fs-6"></i>
                            <span class="mb-0 fs-8">{{ $order->user->name }}</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-envelope text-primary me-2"></i>
                            <span class="mb-0 fs-8">{{ $order->user->email }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h4 class="card-title">Địa chỉ giao hàng</h4>
                <div class="box">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-user text-primary me-2 fs-6"></i>
                            <span class="mb-0 fs-8">{{ $order->userAddress->name }}</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-map-marker text-primary me-2 fs-4"></i>
                            <span class="mb-0 fs-8">{{ $order->userAddress->address }}</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-phone text-primary me-2 fs-5"></i>
                            <span class="mb-0 fs-8">{{ $order->userAddress->phone }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</div>

<div class="card mb-3">
    <div class="card-body">
        <h4 class="card-title">Lịch sử trạng thái đơn hàng</h4>
        <!-- Order Status History -->
        <div class="box">
            <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Người thực hiện</th>
                      <th>Nội dung thực hiện</th>
                      <th>Thời gian</th>
                      <th>Trạng thái đơn hàng</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($order->orderStatusHistory as $history)
                        <tr>
                            <td class="user">
                                {{ $history->user->name ?? 'Hệ thống' }} ({{ $history->user->getRoleString()}})
                                @if($history->user)
                                    <br><span class="user-email">{{ $history->user->email }}</span>
                                @endif
                            </td>
                            <td>{{ $history->note ?? 'Không có ghi chú' }}</td>
                            <td>{{ $history->changed_at}}</td>
                            <td>
                                <label class="badge {{ getBadgeClass($history->status) }} px-3 py-2" style="font-weight: bold; margin-left: 10px;">
                                                {{ $history->getStatusString(); }}
                                </label>
                            </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
                {{-- <button class="btn btn-outline-secondary btn-custom">Gửi hóa đơn</button>                    --}}
        </div> 
    </div>
</div>

</div>


