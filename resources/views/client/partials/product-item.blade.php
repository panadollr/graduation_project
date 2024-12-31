                <div class="product" style="border-radius: 10px">
                    <figure class="product-media">
                        {{-- <span class="product-label label-new">New</span> --}}
                        @if($product->discount_percentage > 0)
                        <span class="product-label label-sale" style="font-size: 15px; font-weight: bold">Giảm giá {{ $product->discount_percentage }}%</span>
                        @endif
                        <a href="{{ route('product', ['product_slug' => $product->slug]) }}">
                            <img src="{{ asset('client/assets/images/loading.gif') }}" class="lazyload"
                            data-src="{{ $product->featured_image }}"
                            onerror="this.onerror=null; this.src='{{ asset('client/assets/images/404.webp') }}';"
                            class="product-image" style="height: 250px; object-fit: contain;">
                        </a>

                        @if($product->isInStock())
                        <div class="product-action">
                            @livewire('client.add-to-cart-button', ['productId' => $product->id])
                        </div><!-- End .product-action -->
                        @endif
                    </figure><!-- End .product-media -->

                    <div class="product-body">
                        <div class="product-cat">
                            <a href="#">{{ $product->category->name }}</a>
                        </div><!-- End .product-cat -->
                        <h3 class="product-title"><a href="{{ route('product', ['product_slug' => $product->slug]) }}">{{ Str::limit($product->name, 30) }}</a></h3><!-- End .product-title -->
                        @if($product->isInStock())
                        <div class="product-price">
                            <span class="new-price">
                                @if($product->discount_percentage > 0)
                                    <span class="original-price">{{ formatVND($product->base_price) }}</span>
                                    <span class="final-price">{{ formatVND($product->sale_price) }}</span>
                                @else
                                    <span class="base-price">{{ formatVND($product->base_price) }}</span>
                                @endif
                            </span>
                            <span class="old-price"></span>
                        </div><!-- End .product-price -->
                        @else
                        <span class="product-label label-sale" style="font-size: 15px; font-weight: bold">hết hàng</span>
                        @endif
                        <div class="ratings-container">
                            <div class="ratings">
                                <div class="ratings-val" style="width: {{ $product->reviews->avg('rating') * 20 }}%;"></div><!-- End .ratings-val -->
                            </div><!-- End .ratings -->
                            <span class="ratings-text">( {{ count($product->reviews) }} Đánh giá )</span>
                        </div><!-- End .rating-container -->
                    </div><!-- End .product-body -->
                </div><!-- End .product -->
