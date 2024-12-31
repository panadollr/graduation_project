@extends('client.app') 

@section('content') 
<div class="page-header text-center" style="padding: 20px;background-image: url({{ asset('client/assets/images/page-header-bg.jpg') }})">
    <div class="container">
        <h3 class="page-title">Chi tiết thanh toán</h3>
    </div><!-- End .container -->
</div><!-- End .page-header -->
<div class="checkout">
    <div class="container">

    @livewire('client.checkout-form', [
        'addresses' => $addresses,
        'checkoutProducts' => $checkoutProducts,
        'shippingMethods' => $shippingMethods,
    ])

    </div><!-- End .container -->
</div><!-- End .checkout -->

@endsection