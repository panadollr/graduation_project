<div>
    <div class="d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #1f3bb3; margin-bottom: 20px;">
        <h6 class="fw-bold text-primary">Đơn hàng của tôi</h6>
    </div>

    <input type="text" class="form-control" placeholder="Tìm kiếm theo tên sản phẩm hoặc ID đơn hàng" wire:model.live="searchTerm">
    <ul class="nav nav-tabs nav-tabs-bg justify-content-center">
        <li class="nav-item" id="tab-1">
            <a class="nav-link {{ $filter === 'all' ? 'active' : '' }}" wire:click="filterOrders('all')" href="#">Tất cả</a>
        </li>
        <li class="nav-item" id="tab-2">
            <a class="nav-link {{ $filter === 'pending' ? 'active' : '' }}" wire:click="filterOrders('pending')" href="#">Đang chờ xác nhận</a>
        </li>
        <li class="nav-item" id="tab-3">
            <a class="nav-link {{ $filter === 'shipped' ? 'active' : '' }}" wire:click="filterOrders('shipped')" href="#">Đang giao hàng</a>
        </li>
        <li class="nav-item" id="tab-4">
            <a class="nav-link {{ $filter === 'completed' ? 'active' : '' }}" wire:click="filterOrders('completed')" href="#">Đã giao hàng</a>
        </li>
        <li class="nav-item" id="tab-5">
            <a class="nav-link {{ $filter === 'cancelled' ? 'active' : '' }}" wire:click="filterOrders('cancelled')" href="#">Đã hủy</a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link {{ $filter === 'return' ? 'active' : '' }}" wire:click="filterOrders('return')" href="#">Trả hàng/Hoàn tiền</a>
        </li> --}}
    </ul>

    <div class="tab-content tab-content-border p-4">
       

        @forelse ($orders as $order)
        <div class="card mb-4 border-black rounded border">
            <div class="card-header d-flex justify-content-between align-items-center p-3" style="border-bottom: 2px solid #1f3bb3;">
                <div>
                    <strong>Đơn hàng #{{ $order['id'] }}</strong>
                    <span>(Ngày đặt: {{ $order['created_at']->format('d/m/Y H:i') }})</span>
                </div>
                <div>
                    Trạng thái: <span class="badge 
                        @if ($order['status'] === 'pending') bg-warning 
                        @elseif ($order['status'] === 'shipped') bg-primary 
                        @elseif ($order['status'] === 'completed') bg-success 
                        @elseif ($order['status'] === 'cancelled') bg-danger 
                        @endif
                        rounded-pill px-3 py-3"
                        style="font-size: 14px; color: white;">
                        {{ $order->getStatusString($order['status']) }}
                    </span>
                </div>
                <div>
                    Hình thức thanh toán: {{ $order->payment_method === 'vnpay' ? 'VNPay' : ($order->payment_method === 'cod' ? 'Thanh toán khi nhận hàng' : 'Khác') }}
                </div>
            </div>
            <div class="card-body">
                <table class="table table-cart table-mobile">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng cộng</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($order['items'] as $orderItem)
                    <tr>
                        <td class="product-col">
                                <div class="product">
                                    <figure class="product-media">
                                        <a href="#">
                                            <img src="{{ $orderItem->product->featured_image }}">
                                        </a>
                                    </figure>
                                    <h3 class="product-title">
                                        <a href="#">{{ $orderItem->product->name }}</a>
                                    </h3><!-- End .product-title -->
                                </div><!-- End .product -->
                            </td>
                            <td class="price-col">{{ formatVND($orderItem->product->sale_price) }}</td>
                            <td class="quantity-col">
                                {{ $orderItem['quantity'] }}
                            </td>
                            <td class="total-col">{{ formatVND($orderItem->product->sale_price * $orderItem->quantity) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        
                <!-- Hiển thị tổng cộng -->
                <p class="d-flex justify-content-between mt-3">
                    <strong>Tạm tính:</strong>
                    <strong class="text-primary">
                        {{ formatVND(collect($order->items)->sum(function ($item) { return $item->product->sale_price * $item->quantity; })) }}
                    </strong>
                </p>
                <p class="d-flex justify-content-between mt-3">
                    <strong>Tiền vận chuyển:</strong>
                    <strong class="text-primary">
                      + {{ formatVND($order->shippingMethod->price)}}
                    </strong>
                </p>
                @if($order->discount)
                <p class="d-flex justify-content-between mt-3">
                    <strong>Áp dụng mã giảm giá:</strong>
                    <strong class="text-primary">
                    - {{ formatVND(($order->items()->sum('price') + $order->shippingMethod->price) * ($order->discount->discount_value / 100)) }}
                    (-{{ (int) $order->discount->discount_value }}%)    
                </strong>
                </p>
                @endif
                <p class="d-flex justify-content-between mt-3">
                    <strong>Tổng cộng:</strong>
                    <strong class="text-primary">
                        {{ formatVND($order->total_price) }}
                    </strong>
                </p>
            </div>
            <div class="card-footer text-end">
                @if ($order['status'] === 'pending')
                    <button class="btn btn-outline-danger btn-sm" wire:click="openCancelModal({{ $order['id'] }})">Hủy đơn</button>
                @endif
            </div>
        </div>        
        @empty
            <div class="text-center mt-3">
                <i class="fas fa-box fa-3x text-primary"></i>
                <h6>Chưa có đơn hàng nào</h6>
            </div>
        @endforelse
    </div>

    <!-- Modal xác nhận hủy đơn hàng -->
    @if ($isCancelModalOpen)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Xác nhận hủy đơn hàng</h5>
                        <button type="button" class="close" wire:click="closeCancelModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 10px">
                        <p>Bạn có chắc chắn muốn hủy đơn hàng này không?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeCancelModal">Đóng</button>
                        <button type="button" class="btn btn-danger" wire:click="cancelOrder">Xác nhận</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
