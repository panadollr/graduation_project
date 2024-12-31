@section('title', $title)

<div class="row">
<div class="col-lg-9">
    <div class="toolbox" style="background: #fff; padding: 10px; border-radius: 10px; font-size: 16px">
        <div class="toolbox-left">
            <div class="toolbox-info" style="font-size: 15px;">
                Hiển thị <span>{{ $products->count() }} trong {{ $products->total() }}</span> sản phẩm
            </div><!-- End .toolbox-info -->
        </div><!-- End .toolbox-left -->

        <div class="toolbox-right">
            <div class="toolbox-sort">
                <label for="sortby" style="font-size: 14px">Sắp xếp theo:</label>
                <div class="select-custom">
                    <select wire:model.live="selectedSort" class="form-control">
                        @foreach ($sortOptions as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>                    
                </div>
            </div><!-- End .toolbox-sort -->
        </div><!-- End .toolbox-right -->
    </div><!-- End .toolbox -->

    <style>
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10;
    }

    </style>

    <div class="products mb-3">
        <div wire:loading class="loading-overlay">
        </div>
        <div class="row justify-content-center">
            @forelse($products as $product)
            <div class="col-6 col-md-4 col-lg-4 col-xl-3" wire:key="product-{{ $product->id }}">
                @include('client.partials.product-item')
            </div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
            @empty
            <div style="height: 300px; display: flex; align-items: center; justify-content: center;">
                <h5>Chưa có sản phẩm nào!</h5>
            </div>
            @endforelse
        </div><!-- End .row -->
    </div><!-- End .products -->

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <!-- Previous Page Link -->
            @if ($products->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link page-link-prev" href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
                        <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Trước đó
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link page-link-prev" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Trước đó
                    </a>
                </li>
            @endif
    
            <!-- Page Number Links -->
            @foreach ($products->links()->elements[0] as $page => $url)
                @if ($page == $products->currentPage())
                    <li class="page-item active" aria-current="page"><a class="page-link" href="#">{{ $page }}</a></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
    
            <!-- Total Pages -->
            <li class="page-item-total">trên {{ $products->lastPage() }}</li>
    
            <!-- Next Page Link -->
            @if ($products->hasMorePages())
                <li class="page-item">
                    <a class="page-link page-link-next" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                        Tiếp theo <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link page-link-next" href="#" aria-label="Next" tabindex="-1" aria-disabled="true">
                        Tiếp theo <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
    
</div><!-- End .col-lg-9 -->
<aside class="col-lg-3 order-lg-first" style="background: #fff; padding: 10px; border-radius: 10px">
    <div class="sidebar sidebar-shop">
        <div class="widget widget-clean">
            <label style="font-size: 15px; font-weight: bold">
                <i class="fas fa-filter" style="margin-right: 8px;"></i>
                Bộ lọc tìm kiếm:
            </label>
            <a href="#" class="sidebar-filter-clear" wire:click.prevent="clearFilters" style="font-size: 13px">Xóa tất cả</a>
        </div><!-- End .widget widget-clean -->

        @if($brands && $brands->count() > 0)
        <div class="widget widget-collapsible">
            <h3 class="widget-title">
                <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1" style="font-size: 15px; font-weight: 600">
                    Hãng sản xuất
                </a>
            </h3><!-- End .widget-title -->

            <div class="collapse show" id="widget-1">
                <div class="widget-body">
                    <div class="filter-items filter-items-count">
                        @foreach($brands as $index => $brand)
                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input"
                                id="brand-{{ $index }}"
                                wire:click="selectBrand('{{ $brand->id }}')" 
                                @if(in_array($brand->id, $selectedBrands)) checked @endif
                                >
                                <label class="custom-control-label" for="brand-{{ $index }}">{{ $brand->name }}</label>
                            </div><!-- End .custom-checkbox -->
                            <span class="item-count">{{ count($brand->products()->get() ) }}</span>
                        </div><!-- End .filter-item -->
                        @endforeach
                    </div><!-- End .filter-items -->
                </div><!-- End .widget-body -->
            </div><!-- End .collapse -->
        </div><!-- End .widget -->
        @endif

        <div class="widget widget-collapsible">
            <h3 class="widget-title">
                <a data-toggle="collapse" style="font-size: 15px; font-weight: 600">
                    Mức giá
                </a>
            </h3>
            
            <div class="collapse show" id="widget-1">
                <div class="widget-body">
                    <div class="filter-items filter-items-count">
                        <select id="price-filter" class="custom-select custom-select-lg" wire:model.live="selectedPrice" style="font-size: 1.25rem; padding: 0.75rem; height: auto;">
                            <option value="" selected>Tất cả</option>
                            @foreach ($priceRanges as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div><!-- End .filter-items -->
                </div><!-- End .widget-body -->
            </div><!-- End .collapse -->

            <div class="collapse show" id="widget-5" wire:ignore> 
                <div class="widget-body">
                    <div class="filter-price">
                        <div class="filter-price-text">
                            Giá từ :
                            <span id="filter-price-range">{{ $minPrice }} - {{ $maxPrice }}</span>
                        </div>
                        <div id="price-slider"></div>
                    </div>
                </div>
            </div>
        </div>
        @section('script')
        <script>
        var priceSlider = document.getElementById("price-slider");
        noUiSlider.create(priceSlider, {
            start: [0, {{ $maxPrice }}],
            connect: true,
            step: 10000,
            range: {
                min: {{ $minPrice }},
                max: {{ $maxPrice }},
            },
            
            format: wNumb({
                decimals: 0,
                thousand: ',',
                suffix: " ₫",
            }),
        });

        priceSlider.noUiSlider.on("update", function (values, handle) {
            $("#filter-price-range").text(values.join(" - "));
        });

        priceSlider.noUiSlider.on("change", function (values) {
        // Call the Livewire method and pass the values
        @this.call('updatePriceRange', 
            values[0].replace(" ₫", "").replace(",", ""), // First value
            values[1].replace(" ₫", "").replace(",", "")  // Second value
        );
    });
        </script>
        @endsection
        
    </div><!-- End .sidebar sidebar-shop -->
</aside><!-- End .col-lg-3 -->
</div><!-- End .row -->