<div class="page-content">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Danh sách bài viết</h1>
        </div><!-- End .container -->
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                @foreach($blogs as $blog)
                <article class="entry entry-list">
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <figure class="entry-media">
                                <a wire:navigate href="{{ route('blog.detail', ['slug' => $blog->slug ])}}">
                                    <img src="{{ Storage::url($blog->image )}}" alt="image desc">
                                </a>
                            </figure><!-- End .entry-media -->
                        </div><!-- End .col-md-5 -->

                        <div class="col-md-7">
                            <div class="entry-body">
                                <div class="entry-meta">
                                    <a href="#">Ngày đăng: {{ optional($blog->created_at)->format('d/m/Y') }}</a>
                                </div><!-- End .entry-meta -->

                                <h2 class="entry-title">
                                    <a wire:navigate href="{{ route('blog.detail', ['slug' => $blog->slug ])}}">{{ $blog->title }}</a>
                                </h2><!-- End .entry-title -->                                

                                <div class="entry-cats">
                                    {{ $blog->category->name }}
                                </div><!-- End .entry-cats -->

                                <div class="entry-content">
                                    <a wire:navigate href="{{ route('blog.detail', ['slug' => $blog->slug ])}}" class="read-more">Đọc tiếp</a>
                                </div><!-- End .entry-content -->
                            </div><!-- End .entry-body -->
                        </div><!-- End .col-md-7 -->
                    </div><!-- End .row -->
                </article><!-- End .entry -->
                @endforeach

                <nav aria-label="Page navigation">
                    {{ $blogs->links()}}
                </nav>
            </div><!-- End .col-lg-9 -->

            <aside class="col-lg-3">
                <div class="sidebar">
                    <div class="widget widget-search">
                        <h3 class="widget-title">Tìm kiếm</h3><!-- End .widget-title -->

                        <form action="#">
                            <label for="ws" class="sr-only">Tìm kiếm trong bài viết</label>
                            <input type="search" class="form-control" wire:model.live="search" placeholder="Tìm kiếm trong bài viết" required>
                            <button type="submit" class="btn"><i class="icon-search"></i><span class="sr-only">Tìm kiếm</span></button>
                        </form>
                    </div><!-- End .widget -->

                    <div class="widget">
                        <h3 class="widget-title">Các bài viết liên quan</h3><!-- End .widget-title -->

                        <ul class="posts-list">
                            @forelse($relatedBlogs as $blog)
                            <li>
                                <figure>
                                    <a href="#">
                                        <img src="{{ Storage::url($blog->image )}}" alt="post" style="min-height: 80px; object-fit: cover">
                                    </a>
                                </figure>

                                <div>
                                    <span>{{ optional($blog->created_at)->format('d/m/Y') }}</span>
                                    <h4><a href="#">{{ limitString($blog->title, 40) }}</a></h4>
                                </div>
                            </li>
                            @empty
                            <p style="text-align: center">Không có bài viết nào</p>
                            @endforelse
                        </ul><!-- End .posts-list -->
                    </div><!-- End .widget -->
                </div><!-- End .sidebar -->
            </aside><!-- End .col-lg-3 -->
        </div><!-- End .row -->
    </div><!-- End .container -->
</div><!-- End .page-content -->