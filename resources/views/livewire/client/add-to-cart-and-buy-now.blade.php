<div>
    <div class="details-filter-row details-row-size" wire:ignore>
        <label for="qty">Số lượng:</label>
        <div class="product-details-quantity">
          <input
            type="number"
            class="form-control"
            wire:model="quantity"
            value="{{ $quantity }}"
            min="1"
            max="10"
            step="1"
            data-decimals="0"
            required
          />
        </div>
        <!-- End .product-details-quantity -->
      </div>
      <!-- End .details-filter-row -->

      <div class="product-details-action">
          <div class="details-action-wrapper">
            <a class="btn-product btn-cart" style="padding-top: 5px; padding-bottom: 5px;"
            @auth
                href="#" wire:click.prevent="toggleCart"
            @else
                href="#signin-modal"
                data-toggle="modal"
            @endauth>
        <span>Thêm vào giỏ hàng</span>
        </a>
        <a class="btn btn-outline-primary-2" style="padding-bottom: 10px; padding-top: 10px; margin-left: 5px"
            @auth
                href="#" wire:click.prevent="buyNow"
            @else
                href="#signin-modal"    
                data-toggle="modal"
            @endauth>
        <span>MUA NGAY</span>
        <i class="fas fa-shopping-bag"></i>
        </a>
          </div>
          <!-- End .details-action-wrapper -->
        </div>
      </div>
<!-- End .product-details-action -->
