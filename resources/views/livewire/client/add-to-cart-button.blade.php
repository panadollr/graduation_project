<a 
    class="btn-product btn-cart" 
    title="Thêm vào giỏ hàng" 
    @auth
        wire:click.prevent="toggleCart"
    @else
        href="#signin-modal"
        data-toggle="modal"
    @endauth
>
    <span>Thêm vào giỏ hàng</span>
</a>

