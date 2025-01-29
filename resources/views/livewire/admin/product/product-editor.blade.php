<div>
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('admin.product.index') }}" class="btn btn-primary btn-sm me-3">
            <i class="fa fa-arrow-left me-1"></i> Danh sách sản phẩm
        </a>
        <h4 class="mb-0">{{ $title ?? '' }}</h4>
    </div>

    <div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" wire:submit.prevent="saveProduct">
                    <div x-data="{ name: @entangle('brandData.name'), slug: @entangle('brandData.slug') }" x-init="slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')">
                    <div class="form-group">
                        <label for="name">Tên sản phẩm</label>
                        <input type="text" class="form-control @error('productData.name') is-invalid @enderror" wire:model="productData.name">
                        @error('productData.name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" class="form-control @error('productData.slug') is-invalid @enderror" wire:model="productData.slug">
                        @error('productData.slug') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div wire:ignore>
                        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
                        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
                    <div class="form-group">
                        <label>Mô tả sơ lược</label>
                        <div id="short_description_editor" style="height: 100px;"></div>
                        <script>
                            var quill1 = new Quill('#short_description_editor', {
                                theme: 'snow'
                            });
                            quill1.clipboard.dangerouslyPasteHTML(@json($productData['short_description']));
                            quill1.on('text-change', function() {
                                const content = quill1.root.innerHTML;
                                @this.set('productData.short_description', content);
                            });
                        </script>
                        @error('productData.short_description') <div class="text-danger">{{ $message }}</div> @enderror 
                    </div>

                    <div class="form-group">
                    <label>Mô tả sản phẩm</label>
                    <div id="editor" style="height: 100px;"></div>
                    <script>
                        var quill = new Quill('#editor', {
                            theme: 'snow'
                        });
                        quill.clipboard.dangerouslyPasteHTML(@json($productData['description']));
                        quill.on('text-change', function() {
                            const content = quill.root.innerHTML;
                            @this.set('productData.description', content);
                        });
                    </script>
                    @error('productData.description') <div class="text-danger">{{ $message }}</div> @enderror 
                    </div>
                    </div>

                </div>
                </form>
            </div>
        </div>
    </div>   

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" wire:submit.prevent="saveProduct">
                    <div class="form-group">
                        <label for="category">Danh mục</label>
                        <select class="form-control @error('productData.category_id') is-invalid @enderror" wire:model="productData.category_id">
                            <option value="">Chọn danh mục</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('productData.category_id') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    {{-- <div class="form-group">
                            <label for="category">Số lượng nhập vào</label>
                            <input class="form-control @error('productData.quantity') is-invalid @enderror" type="number" wire:model="productData.quantity" min="0" step="1">
                            @error('productData.quantity') <div class="text-danger">{{ $message }}</div> @enderror
                    </div> --}}

                    <div x-data="{
                        basePrice: @entangle('productData.base_price'),
                        discountPercentage: @entangle('productData.discount_percentage'),
                        salePrice: @entangle('productData.sale_price'),
                    
                        unformatCurrency(value) {
                            return parseInt(value.replace(/[^0-9]/g, '')) || 0;
                        }, 
                        formatCurrency(value) {
                            return value.toLocaleString('vi-VN');
                        },
                    
                        updateSalePrice() {
                            let discountAmount = (this.unformatCurrency(this.basePrice) * this.discountPercentage) / 100;
                            let newSalePrice = this.unformatCurrency(this.basePrice) - discountAmount;
                            this.salePrice = this.formatCurrency(newSalePrice);  // Format salePrice
                            this.basePrice = this.formatCurrency(this.unformatCurrency(this.basePrice));  // Ensure basePrice is formatted
                        },
                    }" 
                    x-init="basePrice = formatCurrency(unformatCurrency(basePrice)); updateSalePrice();">
                    
                        <div class="form-group">
                            <label>Giá gốc</label>
                            <input class="form-control @error('productData.base_price') is-invalid @enderror" 
                                    type="text" 
                                    x-model="basePrice" 
                                    @input="updateSalePrice()"
                                    placeholder="Nhập giá gốc" />
                            @error('productData.base_price') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    
                        <div class="form-group">
                            <label>Giảm giá (%)</label>
                            <input class="form-control" type="number" x-model="discountPercentage" @input="updateSalePrice()" min="0" step="1">
                            @error('productData.discount_percentage') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    
                        <div class="form-group">
                            <label for="category">Giá bán (Thay đổi theo giá gốc và % giảm giá)</label>
                            <input class="form-control" type="text" x-model="salePrice" readonly disabled>
                            @error('productData.sale_price') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    

                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <select class="form-control" wire:model="productData.status">
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                        @error('productData.status') 
                            <div class="text-danger">{{ $message }}</div> 
                        @enderror
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
<div class="col-md-5 grid-margin stretch-card">
    <div class="card">
    <div class="card-body">
    <div class="form-group">
        <label for="featured_image">Ảnh đại diện</label>
        <input type="file" class="form-control @error('productData.featured_image') is-invalid @enderror" wire:model="productData.featured_image" accept="image/*">
        @error('productData.featured_image') <div class="text-danger">{{ $message }}</div> @enderror
        @if ($productData['featured_image'])
            <div class="mt-3">
                <img src="{{ is_string($productData['featured_image']) ? url($productData['featured_image']) : $productData['featured_image']->temporaryUrl() }}" class="img-fluid" style="max-width: 200px;">
            </div>
        @endif
    </div>         
</div>
</div>
</div>

<div class="col-md-7 grid-margin stretch-card">
    <div class="card">
    <div class="card-body">
    <div class="form-group">
        <label for="additional_images">Các ảnh phụ kèm theo</label>
        <input type="file" class="form-control @error('productData.additional_images') is-invalid @enderror" wire:model="productData.additional_images" multiple accept="image/*">
        @error('productData.additional_images.*') <div class="text-danger">{{ $message }}</div> @enderror
        @if($productData['additional_images'])
            <br>
            <strong>Ảnh đã chọn</strong>
            <div class="mt-3 d-flex flex-wrap">
                @foreach($productData['additional_images'] as $index => $image)
                    <div class="position-relative m-2" style="width: 120px; height: 120px;">
                        <img src="{{ !is_string($image) ? $image->temporaryUrl() : url($image) }}" 
                            class="img-fluid rounded" 
                            style="width: 100%; height: 100%; object-fit: cover; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                        <button type="button" wire:click="removeProductImage({{ $index }})" 
                            class="position-absolute top-0 end-0 btn btn-danger btn-sm p-0" 
                            style="width: 25px; height: 25px; font-size: 16px; text-align: center; border-radius: 50%;">
                            &times;
                        </button>
                    </div>                    
                @endforeach
            </div>
        @endif
    </div>        
</div>
</div>
</div>

</div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary me-2" wire:click="saveProduct">Lưu</button>
        <a href="{{ route('admin.product.index') }}" class="btn btn-light" type="button">Hủy</a>
    </div>   
    <br>
</div>


