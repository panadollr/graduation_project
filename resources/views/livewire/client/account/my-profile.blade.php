<div class="tab-pane">
    <div class="d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #1f3bb3; margin-bottom: 20px;">
        <h6 class="fw-bold text-primary">Hồ sơ của tôi</h6>
    </div>
    <form wire:submit.prevent="save">
        <label for="display_name">Tên Hiển Thị *</label>
        <input type="text" class="form-control" wire:model="display_name" required>
        <small class="form-text">Đây sẽ là cách tên bạn được hiển thị trong phần tài khoản và trong các đánh giá</small>

        <label for="email">Địa chỉ Email *</label>
        <input type="email" class="form-control" wire:model="email" required>

        <label for="current_password">Mật khẩu hiện tại (để trống nếu không muốn thay đổi)</label>
        <input type="password" class="form-control" wire:model="current_password">

        <label for="new_password">Mật khẩu mới (để trống nếu không muốn thay đổi)</label>
        <input type="password" class="form-control" wire:model="new_password">

        <label for="confirm_password">Xác nhận mật khẩu mới</label>
        <input type="password" class="form-control mb-2" wire:model="confirm_password">

        <button type="submit" class="btn btn-outline-primary-2">
            <span>LƯU THAY ĐỔI</span>
            <i class="icon-long-arrow-right"></i>
        </button>

        @if (session()->has('message'))
            <div class="alert alert-success mt-3">
                {{ session('message') }}
            </div>
        @endif
    </form>
</div><!-- .End .tab-pane -->
