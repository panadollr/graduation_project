        <div class="card card-rounded">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="card-title card-title-dash">Đơn hàng gần đây 
                        </h4>
                    </div>
                </div>
                <div class="table-responsive mt-1">
                    <table class="table select-table">
                        <thead>
                            <tr>
                                <th>Khách hàng</th>
                                <th>Email</th>
                                <th>Tổng tiền</th>
                                <th>Ngày đặt hàng</th>
                                <th>Trạng thái đơn hàng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                <h6>{{ $order->userAddress->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h6>{{ $order->user->email }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ formatVND($order->total_price) }}</h6>
                                    </td>
                                    <td>
                                        {{ $order->created_at->format('H:i d/m/Y') }}
                                    </td>
                                    <td>
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
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Không có đơn hàng nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="list align-items-center pt-3">
                        <div class="wrapper w-100">
                            <p class="mb-0">
                                <a href="{{ route('admin.order.index') }}" class="fw-bold text-primary">Xem tất cả <i class="mdi mdi-arrow-right ms-2"></i></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
