@extends('client.account.layout')

@section('main')
<div class="d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #1f3bb3;
            padding-bottom: 10px;
            margin-bottom: 20px;">
            <h6 class="fw-bold text-primary">Tổng quan</h6>
</div>

 <!-- Overview Cards -->
 <div class="row text-center">
    <!-- Total Orders -->
    <div class="col-md-4 mb-4">
        <div class="card shadow">
            <div class="card-body">
                <h5 class="card-title text-primary">Tổng Số Đơn Hàng</h5>
                <h2>{{ $totalOrders }}</h2>
                <p class="text-muted">Số lượng đơn hàng bạn đã mua</p>
            </div>
        </div>
    </div>
    <!-- Total Amount Spent -->
    <div class="col-md-4 mb-4">
        <div class="card shadow">
            <div class="card-body">
                <h5 class="card-title text-success">Tổng Tiền Đã Chi</h5>
                <h2>{{ number_format($totalSpent, 0, ',', '.') }}₫</h2>
                <p class="text-muted">Tổng chi tiêu của bạn</p>
            </div>
        </div>
    </div>
    <!-- Average Spending -->
    <div class="col-md-4 mb-4">
        <div class="card shadow">
            <div class="card-body">
                <h5 class="card-title text-warning">Chi Tiêu Trung Bình</h5>
                <h2>{{ number_format($averageSpent, 0, ',', '.') }}₫</h2>
                <p class="text-muted">Số tiền trung bình mỗi đơn hàng</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders Table -->
<div class="row mt-2">
    <div class="col">
        <h5 >Đơn Hàng Gần Đây</h5>
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-success">
                <tr>
                    <th>#</th>
                    <th>Mã Đơn Hàng</th>
                    <th>Ngày Mua</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentOrders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
                    <td>
                        <span class="badge 
                            {{ $order->status == 'completed' ? 'bg-success' : 
                               ($order->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                            {{ $order->getStatusString($order->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Không có đơn hàng nào</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>

@endsection