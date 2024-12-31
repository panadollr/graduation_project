@extends('client.app') 
@section('content') 
<style>
    body{
        background: #f7f5f5 !important
    }
</style>
<br>
<div class="page-content">
    <div class="dashboard">
        <div class="container">
            <div class="row">
                <aside class="col-md-2 col-lg-2">
                    @include('client.account.components.tablist')
                </aside><!-- End .col-lg-3 -->
                <div class="col-md-10 col-lg-10 bg-white p-4 rounded">
                    @yield('main')
                </div><!-- End .col-lg-9 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .dashboard -->
</div><!-- End .page-content -->

@endsection
