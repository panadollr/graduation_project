<div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="text-center mb-4">
                    Báo cáo doanh thu từ <strong>{{ formatDateDisplay($startDate) }}</strong> đến <strong>{{ formatDateDisplay($endDate) }}</strong>
                </h4>
                
                <!-- Form chọn ngày -->
                <div class="row align-items-center mb-4">
                    <!-- Ngày bắt đầu -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start-date" class="font-weight-bold text-primary">Ngày bắt đầu:</label>
                            <input type="date" wire:model.live="startDate" class="form-control border-primary">
                        </div>
                    </div>
                    
                    <!-- Ngày kết thúc -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="end-date" class="font-weight-bold text-primary">Ngày kết thúc:</label>
                            <input type="date" wire:model.live="endDate" class="form-control border-primary">
                        </div>
                    </div>
                
                    <!-- Tổng số doanh thu -->
                    <div class="col-md-3 text-center">
                        <div class="p-3 border rounded shadow-sm">
                            <strong class="text-muted" style="font-size: 1.1rem;">Tổng doanh thu:</strong>
                            <h5 class="text-danger font-weight-bold mb-0" style="font-size: 1.5rem;">
                                {{ formatVND($revenueStatistics['totalRevenue']) }}
                            </h5>
                        </div>
                    </div>
                
                    <!-- Tổng số đơn hàng -->
                    <div class="col-md-3 text-center">
                        <div class="p-3 border rounded shadow-sm">
                            <strong class="text-muted" style="font-size: 1.1rem;">Tổng đơn hàng:</strong>
                            <h5 class="text-success font-weight-bold mb-0" style="font-size: 1.5rem;">
                                {{ $revenueStatistics['totalOrders'] }}
                            </h5>
                        </div>
                    </div>
                </div>
                
    
                 <!-- Bảng đơn hàng -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID Đơn Hàng</th>
                            <th>Người dùng</th>
                            <th>Ngày đặt hàng</th>
                            <th>Tổng Tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ formatDateDisplay($order->created_at) }}</td>
                                <td><strong>{{ formatVND($order->total_price) }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Hiển thị phân trang -->
                <div class="mt-3">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>


        <div class="card" style="margin-top: 20px">
          <div class="card-body">
        <h4 class="card-title">Thống kê số lượng sản phẩm bán ra và số lượng đơn hàng</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                <label for="start-date">Ngày bắt đầu:</label>
                <input type="date" wire:model.live="startDateOfStatisticsByDateRange" class="form-control border-primary">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="end-date">Ngày kết thúc:</label>
                <input type="date" wire:model.live="endDateOfStatisticsByDateRange" class="form-control border-primary">
                </div>
            </div>
        </div>
        <div style="height: 500px">
        <canvas id="dateRangeChart" wire:ignore></canvas>
        </div>
    </div>
        </div>

    @section('script')
    <script>
            let chart;
            function renderDateRangeChart(labels, product_quantities, orders) {
                const ctx = document.getElementById("dateRangeChart").getContext("2d");
                
                if (chart) {
                    chart.destroy();
                }

                const data = {
                labels: labels,
                datasets: [
                    {
                        label: 'Số lượng sản phẩm bán ra',
                        data: product_quantities,
                        backgroundColor: "#1E3BB3",
                        borderWidth: 1,
                        stack: 'Stack 0', 
                    },
                {
                        label: 'Số lượng đơn hàng',
                        data: orders,
                        backgroundColor: "#51B1E1",
                        borderWidth: 1,
                        stack: 'Stack 1',
                }
                ]
                };

                chart = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                        plugins: {
                        legend: {
                            position: 'top',
                        },
                        }
                    },
                });
            }
    </script>
@endsection
</div>
