<div>
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.user.index') }}" class="btn btn-outline-primary btn-sm me-3">
            <i class="fa fa-arrow-left me-1"></i> Danh sách người dùng
        </a>
        <h3 class="mb-0">{{ $title ?? 'Quản lý người dùng' }}</h3>
    </div>

    <div class="row">
        <!-- Thông tin cơ bản -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white py-3 px-4">
                    <h5 class="mb-0">Thông tin người dùng</h5>
                </div>                
                <div class="card-body">
                    <form wire:submit.prevent="saveUser">
                        <div class="form-group mb-3">
                            <label for="name">Tên người dùng</label>
                            <input type="text" class="form-control" wire:model="userData.name" placeholder="Nhập tên người dùng">
                            @error('userData.name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" wire:model="userData.email" placeholder="Nhập email">
                            @error('userData.email') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Mật khẩu</label>
                            <input type="password" class="form-control" wire:model="userData.password" placeholder="Nhập mật khẩu">
                            @error('userData.password') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="confirm_password">Nhập lại mật khẩu</label>
                            <input type="password" class="form-control" wire:model="userData.confirm_password" placeholder="Nhập lại mật khẩu">
                            @error('userData.confirm_password') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                </div>
            </div>
        </div>

        <!-- Phân quyền -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white py-3 px-4">
                    <h5 class="mb-0">Phân quyền người dùng</h5>
                </div>    
                <div class="card-body">
                    <div class="form-group">
                        <label for="role">Vai trò</label>
                        <select class="form-select" wire:model="userData.role">
                            <option value="">Chọn vai trò</option>
                            <option value="admin">Quản trị viên</option>
                            <option value="employee">Nhân viên</option>
                            <option value="user">Khách hàng</option>
                        </select>
                        @error('userData.role') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <!-- Mô tả vai trò -->
                    @if ($userData['role'])
                        <div class="mt-3">
                            <h6>Mô tả vai trò:</h6>
                            @if ($userData['role'] === 'admin')
                                <h5 class="text-primary">Quản trị viên có toàn quyền quản lý hệ thống, bao gồm quản lý sản phẩm, người dùng và đơn hàng.</h5>
                            @elseif ($userData['role'] === 'employee')
                                <h5 class="text-success">Nhân viên có quyền xem và quản lý sản phẩm, đơn hàng nhưng không có quyền quản trị người dùng.</h5>
                            @elseif ($userData['role'] === 'user')
                                <h5 class="text-danger">Khách hàng chỉ có quyền mua sắm và tương tác với hệ thống.</h5>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Nút hành động -->
    <div class="row">
        <div class="col-12 text-end">
            <button type="submit" class="btn btn-success px-4">
                <i class="fa fa-save me-2"></i> Lưu thông tin
            </button>
        </div>
    </div>
    </form>
</div>
