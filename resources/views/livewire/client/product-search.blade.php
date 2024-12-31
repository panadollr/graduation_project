   <div class="header-search header-search-extended header-search-visible header-search-no-radius d-none d-lg-block">
    <style>
        /* Container chứa ô tìm kiếm */
       .header-search-wrapper {
           position: relative; /* Để danh sách gợi ý xuất hiện dưới input */
       }
       
       /* Danh sách gợi ý */
       .search-suggestions {
           position: absolute;
           top: 100%; /* Xuất hiện ngay dưới ô input */
           left: 0;
           width: 100%;
           background-color: #fff;
           border: 1px solid #ddd;
           border-radius: 4px;
           box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
           z-index: 1000;
           max-height: 300px; /* Giới hạn chiều cao để không quá dài */
           overflow-y: auto; /* Thêm cuộn dọc nếu danh sách quá dài */
           padding: 0; /* Loại bỏ khoảng trống mặc định */
       }
       
       /* Item trong danh sách gợi ý */
       .search-suggestions li {
           display: flex; /* Đặt các thành phần bên trong thành hàng ngang */
           align-items: center; /* Căn giữa theo chiều dọc */
           list-style: none;
           padding: 10px;
           border-bottom: 1px solid #f1f1f1;
           cursor: pointer;
           font-size: 14px;
       }
       
       .search-suggestions li:hover {
           background-color: #f9f9f9; /* Thêm hiệu ứng hover */
       }
       
       /* Hình ảnh sản phẩm */
       .search-suggestions li img {
           width: 50px; /* Kích thước hình ảnh */
           height: 50px;
           object-fit: cover; /* Đảm bảo ảnh không bị méo */
           border-radius: 4px; /* Bo góc nhẹ */
           margin-right: 10px; /* Khoảng cách giữa ảnh và nội dung */
       }
       
       /* Nội dung sản phẩm */
       .search-suggestions li .content {
           flex: 1; /* Để nội dung chiếm toàn bộ không gian còn lại */
       }
       
       /* Ẩn đường viền cuối cùng */
       .search-suggestions li:last-child {
           border-bottom: none;
       }
       
       /* Hiển thị danh sách khi có gợi ý */
       .search-suggestions.active {
           display: block;
       }
       .loading-indicator {
            text-align: center;
            color: #888;
            margin-top: 10px;
            font-size: 14px;
        }
           </style> 
    <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
        <div class="header-search-wrapper search-wrapper-wide">
            <label for="q" class="sr-only">Tìm kiếm</label>
            <input wire:model.live="search" type="search" class="form-control" placeholder="Tìm kiếm sản phẩm theo tên, thương hiệu ..." required>
            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
            @if(count($products) > 0)
            <ul class="search-suggestions {{ count($products) > 0 ? 'active' : '' }}" wire:transition.in>
                @forelse ($products as $index => $product)
                    <li href="javascript:void(0);"
                    onclick="window.location.href='{{ route('product', ['product_slug' => $product->slug]) }}';">
                        <img src="{{ $product->featured_image }}" alt="{{ $product->name }}">
                        <div class="content">
                            <strong>{{ $product->name }}</strong><br>
                            <small style="font-size: 15px">{{ formatVND($product->sale_price) }}</small>
                        </div>
                    </li>
                @empty
                    @if (strlen($search) > 1)
                        <li style="padding: 10px; color: #888;">Không tìm thấy sản phẩm nào.</li>
                    @endif
                @endforelse
            </ul> 
            @endif           
        </div><!-- End .header-search-wrapper -->
</div><!-- End .header-search -->