<style>
    @media (max-width: 768px) {
        .category-dropdown {
            display: none;
            /* Ẩn menu trên thiết bị có màn hình nhỏ */
        }
    }
</style>
<div class="dropdown category-dropdown" style="max-width: 60%; height: 45px;">
    <a style="border-radius: 25px" href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="true" data-display="static" title="Browse Categories">
        Danh mục
    </a>
    <div class="dropdown-menu ">
        <nav class="side-nav">
            <ul class="menu-vertical sf-arrows">


                <li class="megamenu-container">
                    <a class="sf " href="{{ route('blog.index') }}">Danh sách bài viết</a>
                </li>
            </ul><!-- End .menu-vertical -->
        </nav><!-- End .side-nav -->
    </div><!-- End .dropdown-menu -->
</div><!-- End .category-dropdown -->
