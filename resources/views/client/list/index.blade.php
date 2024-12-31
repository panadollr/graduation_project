
@extends('client.app') 
@section('content') 

<style>
    body {
        background-color: #f3f4f6;
    }
</style>

<div class="mb-2"></div>

<div class="page-content">
    <div class="container">
            @livewire('client.product-list', ['category_slug' => $category_slug ?? null, 'search' => $search ?? null])
    </div><!-- End .container -->
</div><!-- End .page-content -->
@endsection
       