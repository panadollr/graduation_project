    <div class="card card-rounded">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title card-title-dash">Top 10 Sản Phẩm Theo Đánh Giá</h4>
                        <div>
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                @if ($sortType === 'high')
                                    Đánh giá cao nhất
                                @else
                                    Đánh giá thấp nhất
                                @endif
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                                <li><a class="dropdown-item" wire:click.prevent="updateSort('high')">Đánh giá cao nhất</a></li>
                                <li><a class="dropdown-item" wire:click.prevent="updateSort('low')">Đánh giá thấp nhất</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-3">
                        @forelse ($topProducts as $product)
                            <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                                <div class="d-flex">
                                    <img class="img-sm rounded-10" src="{{ $product->featured_image }}" alt="product">
                                    <div class="wrapper ms-3">
                                        <p class="ms-1 mb-1 fw-bold">{{ limitString($product->name, 40) }}</p>
                                        <small class="text-muted mb-0">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= floor($product->reviews_avg_rating))
                                                    <i class="fa fa-star text-warning"></i> {{-- Sao đầy màu vàng --}}
                                                @elseif ($i - $product->reviews_avg_rating < 1)
                                                    <i class="fa fa-star-half-alt text-warning"></i> {{-- Sao nửa đầy --}}
                                                @else
                                                    <i class="fa fa-star text-muted"></i> {{-- Sao rỗng --}}
                                                @endif
                                            @endfor
                                        </small>                                        
                                    </div>
                                </div>
                            </div>
                        @empty
                        <center><h5>Chưa có sản phẩm nào !</h5></center>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
