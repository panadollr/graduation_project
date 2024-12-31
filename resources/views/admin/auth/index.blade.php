@extends('admin.app')

@section('title', 'Đăng nhập') <!-- Đặt tiêu đề cho trang -->

@section('content')
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                <div class="brand-logo">
                  <img src="{{ asset('admin/assets/images/logo.png')}}" alt="logo" style="width: 160px">
                </div>
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h4>Xin chào</h4>
                <h6 class="fw-light">Đăng nhập để tiếp tục.</h6>
                <livewire:admin.auth.login />
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
@endsection
