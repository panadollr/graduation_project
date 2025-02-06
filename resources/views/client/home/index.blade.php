@extends('client.app')

@section('content')
    @include('client.home.components.sliders')
    <div class="mb-4"></div>
    @include('client.home.components.popular-categories', ['categories' => $popularCategories])

    <div class="mb-4"></div>

    @include('client.home.components.hot-deals-products')

    <div class="mb-6"></div>


    {{-- @foreach ($categories->take(3) as $category)
        @include('client.home.components.products-by-category', ['category' => $category])
    @endforeach --}}

    <div class="mb-4"></div>

    @include('client.home.components.blogs')
@endsection
