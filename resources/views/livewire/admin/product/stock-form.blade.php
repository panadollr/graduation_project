<div>
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('admin.product.index') }}" class="btn btn-primary btn-sm me-3">
            <i class="fa fa-arrow-left me-1"></i> Danh sách sản phẩm
        </a>
        <h5 class="mb-0">Nhập kho sản phẩm</h5>
    </div>

    <div class="row">
    <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
    <div class="card-body">
    <form wire:submit.prevent="saveStock">
        <!-- Tên sản phẩm -->
        <div class="form-group">
            <label for="product_name">Tên sản phẩm</label>
            <input type="text" class="form-control" value="{{ $product->name }}" disabled>
        </div>

        <div class="row">
        <div class="col-md-6">
        <!-- Số lượng nhập vào -->
        <div class="form-group">
            <label for="current_stock">Số lượng nhập vào</label>
            <input type="number" class="form-control" wire:model.live="quantity" disabled>
        </div>
        </div>

        <div class="col-md-6">
        <!-- Số lượng đã bán -->
        <div class="form-group">
            <label for="quantity_sold">Số lượng đã bán</label>
            <input type="number" class="form-control" wire:model.live="sold_quantity" disabled>
        </div>
        </div>
        </div>

        <!-- Số lượng nhập vào -->
        <div class="form-group">
            <label for="current_stock">Số lượng tồn kho</label>
            <input type="number" class="form-control" wire:model.live="stock" disabled>
        </div>

        <!-- Số lượng nhập thêm -->
        <div class="form-group">
            <label for="quantity_to_add">Thêm số lượng mới</label>
            <input type="number" wire:model="quantity_to_add" class="form-control">
            @error('quantity_to_add') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-2">Lưu</button>
    </form>
    </div>
    </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Lần nhập kho gần nhất:</h4>
                <p>Thời gian: {{ $product->stored_at ??  $product->created_at }}</p>
            </div>
            </div>

        <div class="card mt-3">
        <div class="card-body">
            <h4 class="card-title">Lịch sử nhập kho</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Người thực hiện</th>
                        <th>Số lượng nhập kho</th>
                        <th>Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $log->user->name }}
                                <!-- Hiển thị vai trò bằng nhãn -->
                                <span class="badge {{ $log->user->getRoleBadgeClass() }}">
                                    @if ($log->user->role === 'admin')
                                        Quản trị viên
                                    @elseif ($log->user->role === 'employee')
                                        Nhân viên
                                    @elseif ($log->user->role === 'user')
                                        Khách hàng
                                    @endif
                                </span>
                            </td>
                            <td>{{ $log->quantity_added }}</td>
                            <td>{{ $log->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
    </div>

</div>


