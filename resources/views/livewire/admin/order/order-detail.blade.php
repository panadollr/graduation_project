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

        <div class="card mb-3">
            <div class="card-body">
                <h4 class="card-title">Lịch sử trạng thái đơn hàng</h4>
                <!-- Order Status History -->
                <div class="box">
                        <style>
                            /* Timeline chính */
                            .timeline {
                                list-style: none;
                                padding: 0;
                                margin: 0;
                                position: relative;
                            }
                        
                            .timeline::before {
                                content: '';
                                position: absolute;
                                top: 0;
                                left: 12px;
                                height: 100%;
                                width: 2px;
                                background-color: #e0e0e0;
                            }
                        
                            .timeline-item {
                                display: flex;
                                align-items: flex-start;
                                position: relative;
                                margin-bottom: 16px;
                                padding-left: 40px;
                            }
                        
                            .timeline-item:last-child {
                                margin-bottom: 0;
                            }
                        
                            .timeline-item.active::before {
                                background-color: #4caf50;
                            }
                        
                            .timeline-item::before {
                                content: '';
                                position: absolute;
                                top: 0;
                                left: 6px;
                                width: 12px;
                                height: 12px;
                                border-radius: 50%;
                                background-color: #e0e0e0;
                                z-index: 1;
                            }
                        
                            .timeline-item.active::before {
                                background-color: #4caf50;
                            }
                        
                            /* Thời gian hiển thị */
                            .timeline-time {
                                font-size: 0.875rem;
                                color: #888;
                                width: 80px;
                                text-align: right;
                                margin-right: 16px;
                            }
                        
                            /* Nội dung timeline */
                            .timeline-content {
                                background-color: #f9f9f9;
                                padding: 10px;
                                border-radius: 8px;
                                flex-grow: 1;
                                box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.1);
                            }
                        
                            .status-text {
                                font-weight: bold;
                                margin: 0 0 4px;
                            }
                        
                            .status-user {
                                font-size: 0.875rem;
                                color: #555;
                                margin: 0 0 4px;
                            }
                        
                            .status-note {
                                font-size: 0.875rem;
                                color: #666;
                                margin: 0;
                            }
                        </style>
                
                            <ul class="timeline">
                                @foreach($order->orderStatusHistories as $history)
                                <li class="timeline-item active">
                                    <div class="timeline-time">{{ \Carbon\Carbon::parse($history->changed_at)->format('d/m/Y H:i') }} </div>
                                    <div class="timeline-content">
                                        <div class="status-text">
                                        <label class="badge {{ getBadgeClass($history->status) }}" style="font-weight: bold;">
                                            {{ $history->getStatusString(); }}
                                        </label>
                                        </div>
                                        <div class="status-user">Thực hiện bởi: <strong>{{ $history->user->name ?? 'Hệ thống' }} </strong>
                                            <!-- Hiển thị vai trò bằng nhãn -->
                                            <span class="badge {{ $history->user->getRoleBadgeClass() }}">
                                                @if ($history->user->role === 'admin')
                                                    Quản trị viên
                                                @elseif ($history->user->role === 'employee')
                                                    Nhân viên
                                                @elseif ($history->user->role === 'user')
                                                    Khách hàng
                                                @endif
                                            </span>
                                        </div>
                                        <div class="status-note">{{ $history->note ?? 'Không có ghi chú' }}</div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        
                        {{-- <button class="btn btn-outline-secondary btn-custom">Gửi hóa đơn</button>       --}}
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
                            <span class="mb-0 fs-8">{{ $order->userAddress->address }},
                                {{ $order->userAddress->district_name }},
                                {{ $order->userAddress->ward_name }},
                                {{ $order->userAddress->city_name }}
                            </span>
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

</div>


