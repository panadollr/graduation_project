        <div class="card card-rounded">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="card-title card-title-dash">Top 10 Sản Phẩm Bán Chạy</h4>
                            </div>
                        </div>
                        <div class="mt-3">
                            @foreach ($topProducts as $product)
                                <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                                    <div class="d-flex">
                                        <img class="img-sm rounded-10" src="{{ $product->featured_image }}" alt="product">
                                        <div class="wrapper ms-3">
                                            <p class="ms-1 mb-1 fw-bold">{{ limitString($product->name, 40) }}</p>
                                            <small class="text-muted mb-0">{{ $product->order_items_count }} đơn hàng</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

