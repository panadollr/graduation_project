@php 
  $admin = Auth::user();
@endphp

<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <div class="me-3">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
        <span class="icon-menu"></span>
      </button>
    </div>
    <div>
      <a class="navbar-brand brand-logo" href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('client/assets/images/logo.png') }}" alt="logo" />
      </a>
      <a class="navbar-brand brand-logo-mini" href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('client/assets/images/logo.png') }}" alt="logo" />
      </a>
    </div>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-top">
    <ul class="navbar-nav">
      <li class="nav-item fw-semibold d-none d-lg-block ms-0">
        <h1 class="welcome-text">Chúc bạn một ngày mới tốt lành, <span class="text-black fw-bold">@auth {{ $admin->name }}  @endauth</span></h1>
      </li>
    </ul>
    <ul class="navbar-nav ms-auto">
      @livewire('admin.notification')
     
      <li class="nav-item dropdown d-none d-lg-block user-dropdown">
        <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <img class="img-xs rounded-circle" src="{{ asset('client/assets/images/user-avatar.webp') }}" alt="Profile image"> </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
          <div class="dropdown-header text-center">
            <p class="mb-1 mt-3 fw-semibold">{{ $admin->name ?? '' }}</p>
            <p class="fw-light text-muted mb-0">{{ $admin->email ?? '' }}</p>
          </div>
          {{-- <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> Hồ sơ của tôi</a> --}}
          <a class="dropdown-item" href="{{ route('admin.logout') }}"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Đăng xuất</a>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>