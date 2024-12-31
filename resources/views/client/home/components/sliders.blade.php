<style>
    .intro-slide {
    position: relative;

}

.slide-content {
    position: absolute;
    bottom: 75px;
    left: 50%;
    transform: translateX(-50%);
}
</style>

<div class="intro-slider-container">
    <div class="intro-slider owl-carousel owl-simple owl-nav-inside" data-toggle="owl" data-owl-options='{
            "nav": true,
            "margin": 0,
            "loop": true,
            "items": 1
        }'>

        @foreach($sliders as $slider)
        <div class="intro-slide" 
            style="background-image: url({{ url($slider->image) }}); 
                    background-size: contain; 
                    background-repeat: no-repeat; 
                    background-position: center;">
            <div class="slide-content">
                <a href="{{ $slider->link_url }}" class="btn btn-primary">Xem thêm</a>
            </div>
        </div><!-- End .intro-slide -->
        @endforeach
    </div><!-- End .owl-carousel owl-simple -->

    <span class="slider-loader"></span><!-- End .slider-loader -->
</div><!-- End .intro-slider-container -->
