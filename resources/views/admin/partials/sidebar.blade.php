<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} ">
      <a class="nav-link" href="{{ route('admin.dashboard')}}">
        <i class="mdi mdi-view-dashboard-outline menu-icon"></i>
        <span class="menu-title">Bảng điều khiển</span>
      </a>
    </li>
    
    <li class="nav-item nav-category">Quản lý</li>

    <li class="nav-item {{ request()->routeIs('admin.product.index') || request()->routeIs('admin.product.create') || request()->routeIs('admin.product.edit') || request()->routeIs('admin.product.stock') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.product.index') }}">
        <i class="menu-icon mdi mdi-package-variant-closed"></i>
        <span class="menu-title">Sản phẩm</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.category.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.category.index') }}">
        <i class="menu-icon mdi mdi-shape-outline"></i>
        <span class="menu-title">Danh mục</span>
      </a>
    </li>

    <li class="nav-item">
      <a 
        class="nav-link" 
        data-bs-toggle="collapse" 
        href="#settings" 
        aria-expanded="{{ request()->routeIs('admin.order.index') || request()->routeIs('admin.order.detail') || request()->routeIs('admin.order.report') ? 'true' : 'false' }}" 
        aria-controls="settings">
        <i class="menu-icon mdi mdi-cart-outline"></i>
        <span class="menu-title">Đơn hàng</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->routeIs('admin.order.index') || request()->routeIs('admin.order.detail') || request()->routeIs('admin.order.report') ? 'show' : '' }}" id="settings">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item {{ request()->routeIs('admin.order.index') || request()->routeIs('admin.order.detail') ? 'active' : '' }}"> 
            <a class="nav-link" href="{{ route('admin.order.index') }}">Quản lý đơn hàng</a>
          </li>
          <li class="nav-item {{ request()->routeIs('admin.order.report') ? 'active' : '' }}"> 
            <a class="nav-link" href="{{ route('admin.order.report') }}">Báo cáo và thống kê</a>
          </li>
        </ul>
      </div>
    </li>
    

    <li class="nav-item {{ request()->routeIs('admin.review.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.review.index') }}">
        <i class="menu-icon mdi mdi-comment-outline"></i>
        <span class="menu-title">Đánh giá</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.discount.index') || request()->routeIs('admin.discount.create') || request()->routeIs('admin.discount.edit') ? 'active' : '' }}">
      <a class="nav-link" wire:navigate href="{{ route('admin.discount.index') }}">
        <i class="menu-icon mdi mdi-ticket-percent"></i>
        <span class="menu-title">Mã giảm giá</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.shipping-method.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.shipping-method.index') }}">
          <i class="menu-icon mdi mdi-truck-outline"></i>
          <span class="menu-title">Đơn vị vận chuyển</span>
      </a>
    </li>  

    <li class="nav-item {{ request()->routeIs('admin.user.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.user.index') }}">
        <i class="menu-icon mdi mdi-account-group-outline"></i>
        <span class="menu-title">Người dùng</span>
      </a>
    </li>
    
    <li class="nav-item {{ request()->routeIs('admin.slider.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.slider.index') }}">
        <i class="menu-icon mdi mdi-view-carousel"></i>
        <span class="menu-title">Slider</span>
      </a>
    </li>

    <li  class="nav-item {{ request()->routeIs('admin.blog.index') || request()->routeIs('admin.blog.create') || request()->routeIs('admin.blog.edit') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.blog.index') }}">
        <i class="menu-icon mdi mdi-ticket-percent"></i>
        <span class="menu-title">Bài viết</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.log.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.log.index') }}">
          <i class="menu-icon mdi mdi-history"></i>
          <span class="menu-title">Nhật ký hoạt động</span>
      </a>
    </li>
  

    {{-- <li class="nav-item {{ request()->routeIs('admin.blog.index') ? 'active' : '' }}">
      <a wire:navigate class="nav-link" href="{{ route('admin.blog.index') }}">
        <i class="menu-icon mdi mdi-robot-outline"></i>
        <span class="menu-title">Chatbot</span>
      </a>
    </li>
    
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="settings">
        <i class="menu-icon mdi mdi-cog-outline"></i>
        <span class="menu-title">Cấu hình</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="settings">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="pages/settings/general.html">Danh sách cài đặt </a></li>
          <li class="nav-item"> <a class="nav-link" href="pages/settings/general.html">Cài đặt chung</a></li>
        </ul>
      </div>
    </li> --}}
  </ul>
</nav>
