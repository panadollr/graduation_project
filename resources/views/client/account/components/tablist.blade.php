<ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('account.index') ? 'active' : '' }}" wire:navigate href="{{ route('account.index')}}"" role="tab">Bảng Điều Khiển</a>
            <a class="nav-link {{ request()->routeIs('account.profile.index') ? 'active' : '' }}" href="{{ route('account.profile.index')}}" wire:navigate role="tab">Hồ sơ</a>
            <a class="nav-link {{ request()->routeIs('account.address.index') ? 'active' : '' }}" href="{{ route('account.address.index')}}" wire:navigate role="tab">Địa chỉ giao hàng</a>
            <a class="nav-link {{ request()->routeIs('account.purchase.index') ? 'active' : '' }}" href="{{ route('account.purchase.index')}}" wire:navigate role="tab">Đơn mua</a>
            <a class="nav-link" href="{{ route('account.logout')}}" wire:navigate>Đăng Xuất</a>
        </li>
</ul>