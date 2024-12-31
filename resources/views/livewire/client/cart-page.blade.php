<div>
    <div class="page-content" style="margin-top: -30px">
        <div class="cart">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <table class="table table-cart table-mobile">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng cộng</th>
                                    <th></th>
                                </tr>
                            </thead>
    
                            <tbody>
                                @foreach ($cartItems as $item)
                                <tr>
                                    <td class="product-col">
                                        <div class="product">
                                            <figure class="product-media">
                                                <a href="{{ $item->product->url() }}">
                                                    <img src="{{ $item->product->featured_image }}" alt="Hình ảnh sản phẩm">
                                                </a>
                                            </figure>
                                            <h3 class="product-title">
                                                <a href="{{ $item->product->url() }}">{{ $item->product->name }}</a>
                                            </h3><!-- End .product-title -->
                                        </div><!-- End .product -->
                                    </td>
                                    <td class="price-col">{{ formatVND($item->product->sale_price) }}</td>
                                    <td class="quantity-col" wire:ignore>
                                        <input type="number" class="form-control" value="{{ $item->quantity }}" min="1" max="10" wire:change="updateQuantity({{ $item->id }}, $event.target.value)" />
                                    </td>
                                    <td class="total-col" style="padding: 10px">{{ formatVND($item->quantity * $item->product->base_price) }}</td>
                                    <td class="remove-col">
                                        <button class="btn-remove" wire:click="removeItem({{ $item->id }})"><i class="icon-close"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table><!-- End .table table-wishlist -->
    
                    </div><!-- End .col-lg-9 -->
                    <aside class="col-lg-3">
                        <div class="summary summary-cart">
                            <h3 class="summary-title">Tổng giỏ hàng</h3><!-- End .summary-title -->
    
                            <table class="table table-summary">
                                <tbody>
                                    <tr class="summary-total">
                                        <td>Tổng cộng:</td>
                                        <td>{{ formatVND($totalPrice) }}</td>
                                    </tr><!-- End .summary-total -->
                                </tbody>
                            </table><!-- End .table table-summary -->
    
                            <a wire:navigate href="{{ route('checkout.index')}}" class="btn btn-outline-primary-2 btn-order btn-block">TIẾN HÀNH THANH TOÁN</a>
                        </div><!-- End .summary -->
    
                        <a href="{{ route('home') }}" class="btn btn-outline-dark-2 btn-block mb-3"><span>TIẾP TỤC MUA SẮM</span><i class="icon-refresh"></i></a>
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .cart -->
    </div>
    </div>
    