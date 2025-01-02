<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="title title-border mb-0">Các bài viết</h2><!-- End .title -->
        <a href="{{ route('blog.index') }}" class="text-decoration-underline text-primary">Xem thêm</a>
    </div>
    <div class="owl-carousel owl-simple" data-toggle="owl" 
        data-owl-options='{
            "nav": false, 
            "dots": true,
            "margin": 30,
            "loop": false,
            "responsive": {
                "0": {
                    "items":4
                },
                "420": {
                    "items":4
                },
                "600": {
                    "items":4
                },
                "900": {
                    "items":4
                },
                "1024": {
                    "items":4
                },
                "1280": {
                    "items":4,
                    "nav": true,
                    "dots": false
                }
            }
        }'>
       
        @each('client.partials.blog-item', $blogs, 'item')
    </div><!-- End .owl-carousel -->
</div><!-- End .container -->