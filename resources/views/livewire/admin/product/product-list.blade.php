<div>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item me-4">
                        <h4 class="card-title">Danh sách sản phẩm</h4>
                    </li>
                </ul>

                @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.product.create') }}" type="button" class="btn btn-primary btn-icon-text" >
                    <i class="ti-plus btn-icon-prepend"></i>
                    Thêm mới sản phẩm
                </a>
                @endif
                
            </div>
        </div>
      </nav>
 
      <div class="row">                 
        <div class="col-lg-12 ">
          <div class="card">
            <div class="card-body">
            <nav class="navbar navbar-expand-lg border border-2">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item me-4">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ optional($categories->firstWhere('id', $category_id))->name ?? 'Lọc theo danh mục' }}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                        <li>
                                            <a class="dropdown-item" href="#" wire:click.prevent="filterByCategory(null)">
                                                Tất cả
                                            </a>
                                        </li>
                                        @foreach($categories->whereNull('parent_id') as $category)
                                            <li class="dropdown-item-with-children">
                                                <a class="dropdown-item" href="#" wire:click.prevent="filterByCategory({{ $category->id }})">
                                                    {{ $category->name }} @if($category->childrens->isNotEmpty()) > @endif
                                                </a>
                                                @if($category->childrens->isNotEmpty()) <!-- Kiểm tra nếu có danh mục con -->
                                                    <ul class="dropdown-submenu">
                                                        @foreach($category->childrens as $child)
                                                                <a class="dropdown-item" href="#" wire:click.prevent="filterByCategory({{ $child->id }})">
                                                                   {{ $child->name }}
                                                                </a>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <style>
                                .dropdown-submenu {
                                    display: none;
                                    position: absolute;
                                    left: 100%;
                                    top: 0;
                                    min-width: 200px; /* Chiều rộng tối thiểu của submenu */
                                    background: #f8f9fa; /* Màu nền sáng */
                                    border: 1px solid #ddd; /* Viền nhạt */
                                    border-radius: 5px; /* Bo góc nhẹ */
                                    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ */
                                    opacity: 0;
                                    visibility: hidden; /* Ẩn submenu bằng cách thiết lập opacity và visibility */
                                    transition: opacity 0.3s ease, visibility 0s linear 0.3s; /* Hiệu ứng mờ dần khi hover */
                                }

                                /* Hiển thị danh mục con khi hover vào mục cha */
                                .dropdown-item-with-children:hover .dropdown-submenu {
                                    display: block;
                                    opacity: 1;
                                    visibility: visible; /* Hiển thị submenu khi hover */
                                    transition: opacity 0.3s ease, visibility 0s linear 0s; /* Hiển thị mượt mà */
                                }

                                /* Tăng cường độ hiển thị cho các mục con */
                                .dropdown-item-with-children {
                                    position: relative;
                                }

                                /* Định dạng các mục con bên trong submenu */
                                .dropdown-submenu li {
                                    list-style: none;
                                }

                                /* Tạo khoảng cách cho các mục con */
                                .dropdown-submenu li a {
                                    padding: 8px 20px;
                                    font-size: 14px;
                                    color: #333; /* Màu chữ tối cho dễ đọc */
                                    text-decoration: none;
                                    display: block;
                                    border-radius: 3px; /* Bo góc cho các mục con */
                                    transition: background-color 0.3s ease; /* Hiệu ứng chuyển màu nền khi hover */
                                }

                                /* Đổi màu nền khi hover vào mục con */
                                .dropdown-submenu li a:hover {
                                    background-color: #007bff; /* Màu nền khi hover */
                                    color: white; /* Màu chữ khi hover */
                                }

                                /* Cải thiện vẻ ngoài của mục cha */
                                .dropdown-item a {
                                    padding: 8px 20px;
                                    font-size: 14px;
                                    color: #007bff;
                                    text-decoration: none;
                                    display: block;
                                    border-radius: 3px;
                                    transition: background-color 0.3s ease;
                                }

                                /* Đổi màu nền khi hover vào mục cha */
                                .dropdown-item a:hover {
                                    background-color: #007bff; /* Màu nền khi hover */
                                    color: white; /* Màu chữ khi hover */
                                }
                                </style>
                            </li>

                            <li>
                                <div class="dropdown">
                                    <button class="btn btn-inverse btn-fw dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Lọc theo mức giá
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" wire:click.prevent="filterByPrice(0, 500000)">0 - 500k</a></li>
                                        <li><a class="dropdown-item" href="#" wire:click.prevent="filterByPrice(500000, 1000000)">500k - 1 triệu</a></li>
                                        <li><a class="dropdown-item" href="#" wire:click.prevent="filterByPrice(1000000, 100000000)">Trên 1 triệu</a></li>
                                    </ul>
                                </div>
                            </li>

                            <li>
                                <div class="dropdown">
                                    <button class="btn btn-inverse btn-fw dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Lọc theo tình trạng sản phẩm
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" wire:click="$set('filterCriteria', 'low_sales')">Sản phẩm có lượng bán thấp</a></li>
                                        <li><a class="dropdown-item" href="#" wire:click="$set('filterCriteria', 'in_stock')">Còn hàng</a></li>
                                        <li><a class="dropdown-item" href="#" wire:click="$set('filterCriteria', 'out_of_stock')">Hết hàng</a></li>
                                        <li><a class="dropdown-item" href="#" wire:click="$set('filterCriteria', 'over_one_year')">Tồn kho trên 1 năm</a></li>
                                        <li><a class="dropdown-item" href="#" wire:click="$set('filterCriteria', 'over_three_years')">Tồn kho trên 3 năm</a></li>
                                    </ul>
                                </div>  
                            </li>

                            @if($filterCriteria || $category_id || !empty($priceRange))
                            <li>
                                <button class="btn btn-danger" type="button" wire:click="resetFilters">
                                    Xóa bộ lọc
                                </button>
                            </li>
                            @endif
                        </ul>
                        <form class="d-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                                <x-admin.input.text style="width: 250px" wire:model.live="search" placeholder="Tìm kiếm sản phẩm..."/>
                              </div>
                        </form>
                    </div>
                </div>
              </nav>
   
    <!-- List -->
    <x-admin.table>
        <x-slot name="head">
            <x-admin.table.heading
                sortable
                onSort="sortBy('id')" 
                direction="{{ $sortField === 'id' ? $sortDirection : 'desc' }}">
                ID
            </x-admin.table.heading>
            <x-admin.table.heading>
                Ảnh sản phẩm
            </x-admin.table.heading>
            <x-admin.table.heading>
                Tên sản phẩm
            </x-admin.table.heading>
            <x-admin.table.heading
                sortable
                onSort="sortBy('sale_price')" 
                direction="{{ $sortField === 'sale_price' ? $sortDirection : 'desc' }}">
                Giá bán
            </x-admin.table.heading>
            <x-admin.table.heading>
                Danh mục
            </x-admin.table.heading>
            <x-admin.table.heading>
                Tình trạng
            </x-admin.table.heading>
            
            <x-admin.table.heading 
                sortable
                onSort="sortBy('created_at')" 
                direction="{{ $sortField === 'created_at' ? $sortDirection : 'desc' }}">
                Ngày tạo
            </x-admin.table.heading>
            <x-admin.table.heading>Hành động</x-admin.table.heading>
        </x-slot>

        <x-slot name="body">
            @forelse($products as $product)
            <x-admin.table.row wire:loading.class="opacity-50">
                <x-admin.table.cell>
                    {{ $product->id }} 
                </x-admin.table.cell>
                <x-admin.table.cell>
                    <img src="{{ $product->featured_image }}" style="width: 60px;height: 60px; border-radius: 0%; object-fit: contain"> 
                </x-admin.table.cell>
                <x-admin.table.cell style="max-width: 150px; word-wrap: break-word; white-space: normal; line-height: 1.5">
                    {{ Str::limit($product->name, 50) }}
                </x-admin.table.cell>                
                <x-admin.table.cell>
                    <strong class="text-danger">{{ formatVND($product->sale_price) }}</strong>
                </x-admin.table.cell>
                <x-admin.table.cell>
                        {{ $product->category->name }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    @if($product->getAvailableStock() > 0)
                    <label class="badge badge-success" style="font-weight: bold;">
                        Còn hàng
                    </label>
                @else
                    <label class="badge badge-danger" style="font-weight: bold;">
                        Hết hàng
                    </label>
                @endif
                <p>
                    (Số lượng tồn kho: <strong>{{ $product->getAvailableStock() }}</strong>)
                </p>
                </x-admin.table.cell>
                <x-admin.table.cell>
                    {{ $product->created_at }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    <a href="{{ route('admin.product.stock', ['id' => $product->id]) }}" type="button" class="btn btn-primary p-2">
                        Nhập kho
                    </a>        
                    @if(auth()->user()->role == 'admin')            
                    <a href="{{ route('admin.product.edit', ['id' => $product->id]) }}" type="button" class="btn btn-dark btn-icon-text p-2"> 
                    Sửa<i class="fa fa-edit btn-icon-append"></i>
                    </a>
                    <button type="button" class="btn btn-danger btn-icon-text p-2"
                    @click=" confirm('Bạn chắc chắn muốn xóa màu này?') ? $wire.delete({{ $product->id }}) : false">
                    Xóa<i class="fa fa-trash-o btn-icon-append"></i>
                    </button>
                    @endif
                </x-admin.table.cell>
            </x-admin.table.row>
            @empty
            <x-admin.table.row>
                <x-admin.table.cell colspan="8" class="text-center">Không có sản phẩm nào</x-admin.table.cell>
            </x-admin.table.row>
            @endforelse
        </x-slot>
    </x-admin.table>
    
    <br>
    <!-- Pagination - Always Visible -->
    {{ $products->links() }}

            </div>
          </div>
      </div>
    </div>
    
</div>
