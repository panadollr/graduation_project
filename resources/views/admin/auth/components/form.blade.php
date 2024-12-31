<div>
    <form class="pt-3" wire:submit.prevent="login">
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
        @endif
        <div class="form-group">
            <input type="email" class="form-control form-control-lg {{ $errors->has('email') ? 'is-invalid' : '' }}" id="exampleInputEmail1" 
                   placeholder="Tên tài khoản" wire:model="email">
            <!-- Hiển thị lỗi của email -->
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" class="form-control form-control-lg {{ $errors->has('password') ? 'is-invalid' : '' }}" id="exampleInputPassword1" 
                   placeholder="Mật khẩu" wire:model="password" min="1">
            <!-- Hiển thị lỗi của password -->
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        {{-- <div class="mt-3 d-grid gap-2">
            <button type="submit" class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn">ĐĂNG NHẬP</button>
        </div> --}}
        <div class="mt-3 d-grid gap-2">
            <button type="submit" class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn" wire:loading.attr="disabled">
                <span wire:loading.remove>ĐĂNG NHẬP</span>
                <span wire:loading>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Đang đăng nhập...
                </span>
            </button>
        </div>
        <div class="my-2 d-flex justify-content-between align-items-center">
            <div class="form-check">
                <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" wire:model="remember"> Lưu thông tin 
                </label>
            </div>
            <a href="#" class="auth-link text-black">Quên mật khẩu ?</a>
        </div>
    </form>
</div>