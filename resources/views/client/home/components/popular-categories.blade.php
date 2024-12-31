<div class="container">
    <h2 class="title text-center mb-2">Danh mục nổi bật</h2><!-- End .title -->

    <div class="cat-blocks-container">
        <div class="row">
            @foreach($popularCategories as $category)
            <div class="col-6 col-sm-4 col-lg-2">
                <a href="{{ route('list', ['category_slug' => $category->slug])}}" class="cat-block">
                    <figure>
                        <span>
                            <img src="{{ asset('client/assets/images/loading.gif') }}" class="lazyload"
                                data-src="{{ Storage::url($category->image) }}"
                                onerror="this.onerror=null; this.src='{{ asset('client/assets/images/404.webp') }}';"
                                style="max-height: 140px">
                        </span>
                    </figure>

                    <h3 class="cat-block-title">{{ $category->name }}</h3><!-- End .cat-block-title -->
                </a>
            </div><!-- End .col-sm-4 col-lg-2 -->
            @endforeach
        </div><!-- End .row -->
    </div><!-- End .cat-blocks-container -->
</div>