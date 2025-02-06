<div class="dropdown cart-dropdown">
    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
        data-display="static">
        <i class="icon-shopping-cart"></i>
        <span class="cart-count">{{ count($cartItems) }}</span>
        <span class="cart-txt" style='font-family: sans-serif;'>Giỏ hàng</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right" style="border: 2px solid #1f3bb3; border-radius: 10px">
        @if (count($cartItems) > 0)
            <div class="dropdown-cart-products">
                @foreach ($cartItems->take(5) as $cartItem)
                    <div class="product">
                        <div class="product-cart-details">
                            <h4 class="product-title">
                                <a href="{{ route('product', ['product_slug' => $cartItem->product->slug]) }}">
                                    {{ limitString($cartItem->product->name, 40) }}
                                </a>
                            </h4>

                            <span class="cart-product-info">
                                <span class="cart-product-qty">{{ $cartItem->quantity }}</span>
                                x {{ formatVND($cartItem->product->sale_price) }}
                            </span>
                        </div><!-- End .product-cart-details -->

                        <figure class="product-image-container">
                            <a href="{{ route('product', ['product_slug' => $cartItem->product->slug]) }}"
                                class="product-image">
                                <img src="{{ $cartItem->product->featured_image }}" alt="product">
                            </a>
                        </figure>
                        <a href="#" class="btn-remove" title="Remove Product"
                            wire:click.prevent="removeFromCart({{ $cartItem->id }})">
                            <i class="icon-close"></i>
                        </a>
                    </div><!-- End .product -->
                @endforeach
            </div><!-- End .cart-product -->

            @if (count($cartItems) > 5)
                <div class="dropdown-cart-action d-flex justify-content-center">
                    <a href="{{ route('cart.index') }}">
                        <span>Còn {{ count($cartItems) - 5 }} sản phẩm nữa </span>
                        <i class="icon-long-arrow-right"></i>
                    </a>
                </div>
            @endif

            <div class="dropdown-cart-total">
                <span>Tổng cộng</span>
                <span class="cart-total-price">{{ formatVND($totalPrice) }}</span>
            </div><!-- End .dropdown-cart-total -->

            <div class="dropdown-cart-action">
                <a href="{{ route('cart.index') }}" class="btn btn-primary">Xem giỏ hàng</a>
                <a href="{{ route('checkout.index') }}" class="btn btn-outline-primary-2">
                    <span>Thanh toán</span>
                    <i class="icon-long-arrow-right"></i>
                </a>
            </div><!-- End .dropdown-cart-action -->
        @else
            <p style="text-align: center; font-size: 15px">Chưa có sản phẩm nào</p>
        @endif
    </div>
</div>
