@extends('client.app') 

@section('title', $product->name)
@section('content') 
<br>
<nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
    <div class="container d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Danh sách sản phẩm</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->

<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="product-details-top">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="product-gallery">
                                <figure class="product-main-image">
                                    @if($product->discount_percentage > 0)
                                    <span class="product-label label-sale" style="font-size: 15px; font-weight: bold">Giảm giá {{ $product->discount_percentage }}%</span>
                                    @endif
                                    <img style="" 
                                        id="product-zoom" src="{{ $product->featured_image }}" 
                                        class="lazyload"
                                        data-src="{{ $product->featured_image }}"
                                        onerror="this.onerror=null; this.src='{{ asset('client/assets/images/404.webp') }}';">
                                </figure><!-- End .product-main-image -->

                                <div id="product-zoom-gallery" class="product-image-gallery">
                                    <a class="product-gallery-item active" href="#" data-image="{{ $product->featured_image }}">
                                        <img src="{{ $product->featured_image }}" alt="product side">
                                    </a>
                                    @foreach($product->getImages() as $image)
                                    <a class="product-gallery-item" href="#" data-image="{{ url($image) }}">
                                        <img src="{{ url($image) }}" alt="product side">
                                    </a>
                                    @endforeach
                                </div><!-- End .product-image-gallery -->
                                

                            </div><!-- End .product-gallery -->
                        </div><!-- End .col-md-6 -->
            
                        <style>
                            .loading-overlay {
                                position: fixed; /* Đặt overlay ở chế độ fixed */
                                top: 0; /* Bắt đầu từ vị trí trên cùng */
                                left: 0; /* Bắt đầu từ bên trái */
                                width: 100%; /* Chiều rộng 100% */
                                height: 100%; /* Chiều cao 100% */
                               
                                z-index: 9999; /* Đặt lên trên các thành phần khác */
                                display: flex; /* Sử dụng Flexbox để căn giữa */
                                justify-content: center; /* Căn giữa theo chiều ngang */
                                align-items: center; /* Căn giữa theo chiều dọc */
                            }
                        </style>
                
                        <!-- Hiển thị loading khi đang chuyển đổi phiên bản -->
                        <div wire:loading class="loading-overlay"></div>
            
                        <div class="col-md-6">
                            <div class="product-details product-details-sidebar">
                                <h1 class="product-title">{{ $product->name }}</h1><!-- End .product-title -->            
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: {{ $product->reviews()->avg('rating') * 20 }}%;"></div><!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <a class="ratings-text" href="#product-review-link" id="review-link">( {{ count($product->reviews) }} Đánh giá )</a>
                                </div>
            
                                <div class="product-price">
                                    @if($product->discount_percentage > 0)
                                    <span class="original-price">{{ formatVND($product->base_price) }}</span>
                                    <span class="final-price">{{ formatVND($product->sale_price) }}</span>
                                    @else
                                        <span class="base-price">{{ formatVND($product->base_price) }}</span>
                                    @endif
                                </div><!-- End .product-price -->

                                <div class="product-content">
                                    {!! $product->short_description !!}
                                  </div>
            
                                <div class="product-details-action">
                                    @livewire('client.add-to-cart-and-buy-now', ['productId' => $product->id])
                                </div><!-- End .product-details-action -->
                                
            
                                <div class="product-details-footer details-footer-col">
                                    <div class="product-cat">
                                        <span>Danh mục:</span>
                                        @if($product->category->parent)
                                            @foreach($product->category->ancestors() as $ancestor)
                                            <a href="#">{{ $ancestor->name }}</a>
                                            <span> > </span>
                                            @endforeach
                                        @endif
                                        <a href="#">{{ $product->category->name }}</a>
                                        @if($product->category->childrens->isNotEmpty())
                                            <span> > </span>
                                            @foreach($product->category->childrens as $subcategory)
                                                <a href="#">{{ $subcategory->name }}</a>{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        @endif
                                    </div><!-- End .product-cat -->
            
                                </div><!-- End .product-details-footer -->
                            </div><!-- End .product-details -->
                        </div><!-- End .col-md-6 -->
                    </div><!-- End .row -->
                </div><!-- End .product-details-top -->
            </div><!-- End .col-lg-9 -->
    
            <aside class="col-lg-3">
                <div class="sidebar sidebar-product">
                    <div class="widget widget-products">
                        <h4 style="text-align: center;font-size: 20px" class="widget-title">Sản phẩm liên quan</h4><!-- End .widget-title -->
    
                        <div class="products">
                            @forelse($relatedProducts as $product)
                            <div class="product product-sm" style="border: 0.1rem solid #dadada; border-radius: 10px; ">
                                <figure class="product-media">
                                    <a href="{{ route('product', ['product_slug' => $product->slug]) }}">
                                        <img src="{{ asset('client/assets/images/loading.gif') }}" class="lazyload"
                                        data-src="{{ $product->featured_image }}"
                                        onerror="this.onerror=null; this.src='{{ asset('client/assets/images/404.webp') }}';"
                                        class="product-image">
                                    </a>
                                </figure>
                                <div class="product-body">
                                    <h5 class="product-title"><a href="{{ route('product', ['product_slug' => $product->slug]) }}">{{ Str::limit($product->name, 50) }}</a></h5><!-- End .product-title -->
                                    <div class="product-price">
                                    @if($product->discount_percentage > 0)
                                    <span class="original-price">{{ formatVND($product->base_price) }}</span>
                                    <span class="final-price">{{ formatVND($product->sale_price) }}</span>
                                    @else
                                        <span class="base-price">{{ formatVND($product->base_price) }}</span>
                                    @endif
                                    </div><!-- End .product-price -->
                                </div><!-- End .product-body -->
                            </div><!-- End .product product-sm -->
                            @empty
                            <center><h6>Chưa có sản phẩm nào !</h6></center>
                            @endforelse
                        </div><!-- End .products -->
                    </div><!-- End .widget widget-products -->
                </div><!-- End .sidebar sidebar-product -->
            </aside><!-- End .col-lg-3 -->
        </div>

        <div class="product-details-tab">
            <ul class="nav nav-pills justify-content-center" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" aria-selected="true">Thông tin chi tiết</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="product-review-link" data-toggle="tab" href="#product-review-tab" role="tab" aria-controls="product-review-tab" aria-selected="false">Đánh giá</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                    <div class="product-desc-content">
                        <h3>Thông tin chi tiết</h3>
                        {!! $product->description !!}
                    </div><!-- End .product-desc-content -->
                </div><!-- .End .tab-pane -->
                
                @livewire('client.product-review', ['productId' => $productId])

            </div><!-- End .tab-content -->
        </div><!-- End .product-details-tab -->

       @include('client.product-detail.components.also-likes')
    </div><!-- End .container -->
</div><!-- End .page-content -->
@endsection

@section('script')

@endsection

       