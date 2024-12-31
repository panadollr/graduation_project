<style>
    @media (max-width: 768px) {
    .category-dropdown {
        display: none; /* Ẩn menu trên thiết bị có màn hình nhỏ */
    }
}

</style>
<div class="dropdown category-dropdown" style="max-width: 60%; height: 45px;">
    <a style="border-radius: 25px" href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" data-display="static" title="Browse Categories">
        Danh mục
    </a>
    <div class="dropdown-menu ">
        <nav class="side-nav">
            <ul class="menu-vertical sf-arrows">
                @foreach($categories as $category)
                <li class="megamenu-container">
                    <a class="sf {{ !empty($category->childrens) && $category->childrens->count() > 0 ? '-with-ul' : '' }}" href="{{ route('list', ['category_slug' => $category->slug])}}">{{ $category->name }}</a>
                    <div class="megamenu">
                        <div class="row no-gutters">
                            <div class="col-md-8">
                                <div class="menu-col">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @foreach($category->childrens as $children)
                                            <a href="{{ route('list', ['category_slug' => $children->slug])}}" class="menu-title">{{ $children->name }} ></a><!-- End .menu-title -->
                                            {{-- <ul>
                                                <li><a href="#">Carrier Phones</a></li>
                                            </ul> --}}
                                            @endforeach
                                        </div><!-- End .col-md-6 -->
                                    </div><!-- End .row -->
                                </div><!-- End .menu-col -->
                            </div><!-- End .col-md-8 -->

                            <div class="col-md-4">
                                <div class="banner banner-overlay">
                                    <a href="category.html" class="banner banner-menu">
                                        <img src="assets/images/demos/demo-13/menu/banner-1.jpg" alt="Banner">
                                    </a>
                                </div><!-- End .banner banner-overlay -->
                            </div><!-- End .col-md-4 -->
                        </div><!-- End .row -->
                    </div><!-- End .megamenu -->
                </li>
                @endforeach

                <li class="megamenu-container">
                    <a class="sf " href="{{ route('blog.index') }}">Danh sách bài viết</a>
                </li>
            </ul><!-- End .menu-vertical -->
        </nav><!-- End .side-nav -->
    </div><!-- End .dropdown-menu -->
</div><!-- End .category-dropdown -->