<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash">Danh sách sản phẩm nổi bật</h4>
            </div>

            <div>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    @if ($filterType === 'top_rated')
                        Đánh giá cao
                    @elseif ($filterType === 'most_added_to_cart')
                        Thêm vào giỏ hàng nhiều
                    @elseif ($filterType === 'best_selling')
                        Bán chạy
                    @else
                        Chọn bộ lọc
                    @endif
                </button>
                <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                    <li><a class="dropdown-item" wire:click="$set('filterType', 'top_rated')">Đánh giá cao</a></li>
                    <li><a class="dropdown-item" wire:click="$set('filterType', 'most_added_to_cart')">Thêm vào giỏ hàng nhiều</a></li>
                    <li><a class="dropdown-item" wire:click="$set('filterType', 'best_selling')">Bán chạy</a></li>
                </ul>                
            </div>

        </div>
        <div class="table-responsive mt-1">
            <table class="table select-table">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Giá bán</th>
                        <th>Đánh giá trung bình</th>
                        <th>Số lượt thêm vào giỏ hàng</th>
                        <th>Đã bán</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>
                                <div style="max-width: 250px; word-wrap: break-word; white-space: normal; line-height: 1.4">
                                    <div>
                                        <h6>{{ $product->name }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h6>{{ formatVND($product->sale_price) }}</h6>
                            </td>
                            <td>
                                <h6>{{ number_format($product->reviews_avg_rating, 1) }} / 5</h6>
                            </td>
                            <td>
                                <h6>{{ $product->carts_count }}</h6>
                            </td>
                            <td>
                                <h6>{{ $product->sold_quantity }}</h6>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center"><h6>Không có sản phẩm nào phù hợp.</h6></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
