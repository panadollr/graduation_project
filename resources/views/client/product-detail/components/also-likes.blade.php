<h2 class="title text-center mb-4">Có thể bạn sẽ thích</h2><!-- End .title text-center -->

<div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
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
        },
        "992": {
            "items":4
        },
        "1200": {
            "items":4,
            "nav": true,
            "dots": false
        }
    }
}'>

@each('client.partials.product-item', $alsoLikeProducts, 'product')

</div><!-- End .owl-carousel -->