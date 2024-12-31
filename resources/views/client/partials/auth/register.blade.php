<form wire:submit.prevent="register">
    <div class="form-group">
        <label for="register-name">Tên tài khoản *</label>
        <input type="text" id="register-name" class="form-control" wire:model="name" required>
        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="register-email">Email *</label>
        <input type="email" id="register-email" class="form-control" wire:model="email" required>
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="register-password">Mật khẩu *</label>
        <input type="password" id="register-password" class="form-control" wire:model="password" required>
        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="register-password-confirm">Nhập lại mật khẩu *</label>
        <input type="password" id="register-password-confirm" class="form-control" wire:model="password_confirmation" required>
        @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
    </div> 

    <div class="form-footer">
        <button type="submit" class="btn btn-outline-primary-2">
            <span>ĐĂNG KÝ</span>
            <i class="icon-long-arrow-right"></i>
        </button>
    </div>
</form>
