<div class="bg-light pt-3 pb-5">
    <div class="container">
        <div class="heading heading-flex heading-border mb-3">
            <div class="heading-left">
                <h2 class="title">Sản Phẩm Đang Giảm Giá</h2><!-- End .title -->
            </div><!-- End .heading-left -->

           <div class="heading-right">
                <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="hot-all-link" data-toggle="tab" href="#hot-all-tab" role="tab" aria-controls="hot-all-tab" aria-selected="true">Tất cả</a>
                    </li>
                    @foreach($categoriesOfSaleProducts as $category)
                    <li class="nav-item">
                        <a class="nav-link" id="hot-{{ $category->id }}-products-link" data-toggle="tab" href="#hot-{{ $category->id }}-products-tab" role="tab" aria-controls="hot-{{ $category->id }}-products-tab" aria-selected="false">{{ $category->name }}</a>
                    </li>
                    @endforeach
                </ul>
           </div><!-- End .heading-right -->
        </div><!-- End .heading -->

        <div class="tab-content tab-content-carousel">
            <div class="tab-pane p-0 fade show active" id="hot-all-tab" role="tabpanel" aria-labelledby="hot-all-link">
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                    data-owl-options='{
                        "nav": false, 
                        "dots": true,
                        "margin": 20,
                        "loop": false,
                        "responsive": {
                            "0": {
                                "items":2
                            },
                            "480": {
                                "items":2
                            },
                            "768": {
                                "items":3
                            },
                            "992": {
                                "items":4
                            },
                            "1280": {
                                "items":5,
                                "nav": true
                            }
                        }
                    }'>
                    @each('client.partials.product-item', $saleProducts, 'product')
                </div><!-- End .owl-carousel -->
            </div><!-- .End .tab-pane -->

            @foreach($categoriesOfSaleProducts as $category)
            <div class="tab-pane p-0 fade" id="hot-{{ $category->id }}-products-tab" role="tabpanel" aria-labelledby="hot-{{ $category->id }}-products-link">
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                    data-owl-options='{
                        "nav": false, 
                        "dots": true,
                        "margin": 20,
                        "loop": false,
                        "responsive": {
                            "0": {
                                "items":2
                            },
                            "480": {
                                "items":2
                            },
                            "768": {
                                "items":3
                            },
                            "992": {
                                "items":4
                            },
                            "1280": {
                                "items":5,
                                "nav": true
                            }
                        }
                    }'>
                    @if($category->allProducts()->exists())
                        @each('client.partials.product-item', $category->allProducts()->orderByDesc('discount_percentage')->get(), 'product')
                    @else
                        @include('client.partials.no-products')
                    @endif

                </div><!-- End .owl-carousel -->
            </div><!-- .End .tab-pane -->
            @endforeach

        </div><!-- End .tab-content -->
    </div><!-- End .container -->
</div><!-- End .bg-light pt-5 pb-5 -->