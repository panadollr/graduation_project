<form wire:submit.prevent="login">
    <div class="form-group">
        <label for="login-email">Email *</label>
        <input type="email" id="login-email" class="form-control" wire:model="email" required>
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="login-password">Mật khẩu *</label>
        <input type="password" id="login-password" class="form-control" wire:model="password" required>
        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <style>
        button:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }
    </style>

    <div class="form-footer">
        <button type="submit" class="btn btn-outline-primary-2" wire:loading.attr="disabled">
            <span wire:loading.remove>ĐĂNG NHẬP</span>
            <span wire:loading>ĐANG ĐĂNG NHẬP...</span>
            <i class="icon-long-arrow-right" wire:loading.remove></i>
        </button>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="remember" wire:model="remember">
            <label class="custom-control-label" for="remember">Ghi nhớ tài khoản</label>
        </div>
    </div>
</form>
