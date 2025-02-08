<div class="container electronics">
    <div class="heading heading-flex heading-border mb-3">
        <div class="heading-left">
            <h2 class="title">{{ $category->name }}</h2><!-- End .title -->
        </div><!-- End .heading-left -->

        <div class="heading-right">
            <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="new-link-{{ $category->id }}" data-toggle="tab"
                        href="#new-tab-{{ $category->id }}" role="tab" aria-controls="new-tab-{{ $category->id }}"
                        aria-selected="true">Mới nhất</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="best-seller-link-{{ $category->id }}" data-toggle="tab"
                        href="#best-seller-tab-{{ $category->id }}" role="tab"
                        aria-controls="best-seller-tab-{{ $category->id }}" aria-selected="false">Bán chạy nhất</a>
                </li>
            </ul>
        </div><!-- End .heading-right -->
    </div><!-- End .heading -->

    <div class="tab-content tab-content-carousel">
        <div class="tab-pane p-0 fade show active" id="new-tab-{{ $category->id }}" role="tabpanel"
            aria-labelledby="new-link-{{ $category->id }}">
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
                @php $latestProducts = $category->allProducts()->latest()->get(); @endphp
                @if ($latestProducts->isNotEmpty())
                    @each('client.partials.product-item', $latestProducts, 'product')
                @else
                    @include('client.partials.no-products')
                @endif
            </div><!-- End .owl-carousel -->
        </div><!-- .End .tab-pane -->
        <div class="tab-pane p-0 fade" id="best-seller-tab-{{ $category->id }}" role="tabpanel"
            aria-labelledby="best-seller-link-{{ $category->id }}">
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
                @php $bestSellingProducts = $category->allProducts()->where('sold_quantity', '!=', 0)->orderByDesc('sold_quantity')->get(); @endphp
                @if (count($bestSellingProducts) > 0)
                    @each('client.partials.product-item', $bestSellingProducts, 'product')
                @else
                    @include('client.partials.no-products')
                @endif
            </div><!-- End .owl-carousel -->
        </div><!-- .End .tab-pane -->
    </div><!-- End .tab-content -->
</div><!-- End .container -->
