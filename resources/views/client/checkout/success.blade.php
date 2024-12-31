<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    <meta name="csrf_token" value="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('client/assets/images/favicon.png') }}" />
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center text-center error-page bg-success">
                <div class="row flex-grow">
                    <div class="col-lg-7 mx-auto text-white">
                        <h2 class="fw-light text-center mb-4">Cảm ơn bạn đã mua sắm tại <strong>Lân Tech</strong></h2>
                        <h2 class="text-center mb-4">Đơn hàng của bạn đã được đặt thành công!</h2>
                        
                        <div class="row align-items-center d-flex flex-row">
                            <div class="col-lg-5 text-lg-center pr-lg-4">
                                <h1 class="display-1 mb-0"><i class="mdi mdi-check-circle-outline"></i></h1>
                            </div>
                            <div class="col-lg-7 text-lg-left pl-lg-6">
                                <h3>Chúng tôi đã gửi thông tin đơn hàng đến hộp thư Gmail của bạn: <strong>{{ auth()->user()->email }}</strong></h3>
                                <p>Chúng tôi sẽ xử lý đơn hàng và thông báo cho bạn trong thời gian sớm nhất.</p>
                            </div>
                        </div>
                
                        <div class="row mt-5">
                            <div class="col-12 text-center">
                                <a href="{{ route('account.purchase.index')}}" class="btn btn-primary btn-lg mr-3">Kiểm tra đơn hàng</a>
                                <a href="{{ route('home') }}" class="btn btn-dark btn-lg">Về trang chủ</a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('admin/assets/js/template.js') }}"></script>
</body>
</html>
