<div class="container">
    <h2 class="title title-border mb-5">Các bài viết</h2><!-- End .title -->
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