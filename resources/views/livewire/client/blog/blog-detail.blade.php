<div class="page-content">
    <figure class="entry-media">
        <img src="{{ Storage::url($blog->image)}}" style="height: 250px; object-fit: cover" alt="image desc">
    </figure><!-- End .entry-media -->
    <div class="container">
        <article class="entry single-entry entry-fullwidth">
                    <div class="entry-body">
                        <div class="entry-meta">
                            <span href="#">Ngày đăng: {{ optional($blog->created_at)->format('d/m/Y') }}</span>
                        </div><!-- End .entry-meta -->
                        <h2 class="entry-title entry-title-big">
                            {{ $blog->title}}
                        </h2><!-- End .entry-title -->

                        <div class="entry-content editor-content">
                            {!! $blog->content !!}
                        </div><!-- End .entry-content -->
                    </div><!-- End .entry-body -->
        </article><!-- End .entry -->

        <nav class="pager-nav" aria-label="Page navigation">
            @if($previousBlog)
                <a class="pager-link pager-link-prev" wire:navigate href="{{ route('blog.detail', ['slug' => $previousBlog->slug ])}}" aria-label="Previous">
                    Bài viết trước
                    <span class="pager-link-title">{{ $previousBlog->title }}</span>
                </a>
            @else
                <a class="pager-link " aria-label="Previous"></a>
            @endif

            @if($nextBlog)
                <a class="pager-link pager-link-next" wire:navigate href="{{ route('blog.detail', ['slug' => $nextBlog->slug ])}}" aria-label="Next">
                    Bài viết tiếp theo
                    <span class="pager-link-title">{{ $nextBlog->title }}</span>
                </a>
            @else
                <a class="pager-link " aria-label="Previous"></a>
            @endif
        </nav><!-- End .pager-nav -->

        <div class="related-posts">
            <h3 class="title">Các bài viết liên quan</h3><!-- End .title -->
            
            <div class="owl-carousel owl-simple" data-toggle="owl" 
                                    data-owl-options='{
                                        "nav": false, 
                                        "dots": true,
                                        "margin": 20,
                                        "loop": false,
                                        "responsive": {
                                            "0": {
                                                "items":1
                                            },
                                            "480": {
                                                "items":2
                                            },
                                            "768": {
                                                "items":3
                                            }
                                        }
                                    }'>
                                    
                                    @each('client.partials.blog-item', $blog->relatedBlogs(), 'item')
                                   
                                </div><!-- End .owl-carousel -->
        </div><!-- End .related-posts -->

    </div><!-- End .container -->
</div>