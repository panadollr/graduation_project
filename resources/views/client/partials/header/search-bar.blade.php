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
        display: none; /* Ẩn mặc định, sẽ hiển thị khi có dữ liệu */
        max-height: 300px; /* Giới hạn chiều cao để không quá dài */
        overflow-y: auto; /* Thêm cuộn dọc nếu danh sách quá dài */
    }
    
    /* Item trong danh sách gợi ý */
    .search-suggestions li {
        list-style: none;
        padding: 10px;
        border-bottom: 1px solid #f1f1f1;
        cursor: pointer;
        font-size: 14px;
    }
    
    .search-suggestions li:hover {
        background-color: #f9f9f9; /* Thêm hiệu ứng hover */
    }
    
    /* Ẩn đường viền cuối cùng */
    .search-suggestions li:last-child {
        border-bottom: none;
    }
    
    /* Hiển thị danh sách khi có gợi ý */
    .search-suggestions.active {
        display: block;
    }
    </style>    

<div class="header-search header-search-extended header-search-visible header-search-no-radius d-none d-lg-block">
    <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
    <form action="{{ route('search') }}" method="get">
        <div class="header-search-wrapper search-wrapper-wide">
            <label for="q" class="sr-only">Tìm kiếm</label>
            <input type="search" class="form-control" name="s" id="q" placeholder="Tìm kiếm sản phẩm theo tên, thương hiệu ..." required>
            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
            <ul class="search-suggestions" id="suggestions">
                <!-- Các item gợi ý sẽ được thêm vào đây -->
            </ul>
        </div><!-- End .header-search-wrapper -->
    </form>
</div><!-- End .header-search -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('q');
    const suggestions = document.getElementById('suggestions');

    // Dữ liệu gợi ý mẫu (thay thế bằng dữ liệu từ server)
    const sampleData = [
        'iPhone 14 Pro Max',
        'Samsung Galaxy S23',
        'Laptop Dell XPS 15',
        'Apple AirPods Pro',
        'Sony WH-1000XM5',
    ];

    // Lắng nghe sự kiện nhập vào ô tìm kiếm
    searchInput.addEventListener('input', function () {
        const query = this.value.toLowerCase();
        suggestions.innerHTML = ''; // Xóa danh sách cũ

        if (query) {
            // Lọc danh sách theo từ khóa nhập vào
            const filteredData = sampleData.filter(item => 
                item.toLowerCase().includes(query)
            );

            // Thêm các gợi ý vào danh sách
            filteredData.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item;
                li.addEventListener('click', function () {
                    searchInput.value = item; // Gán giá trị vào ô input
                    suggestions.classList.remove('active'); // Ẩn danh sách
                });
                suggestions.appendChild(li);
            });

            // Hiển thị danh sách nếu có gợi ý
            suggestions.classList.toggle('active', filteredData.length > 0);
        } else {
            suggestions.classList.remove('active'); // Ẩn danh sách nếu không có từ khóa
        }
    });

    // Ẩn danh sách gợi ý khi click ra ngoài
    document.addEventListener('click', function (e) {
        if (!document.querySelector('.header-search-wrapper').contains(e.target)) {
            suggestions.classList.remove('active');
        }
    });
});
</script>