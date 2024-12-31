<div>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item me-4">
                        <h4 class="card-title">Danh sách danh mục</h4>
                    </li>
                </ul>
                <button wire:click="create" type="button" class="btn btn-primary btn-icon-text" 
                 wire:loading.attr="disabled" wire:loading.class="loading">
                  <i class="ti-plus btn-icon-prepend" wire:loading.remove wire:target="create"></i>
                <span wire:loading.remove wire:target="create">Thêm danh mục</span>
                <span wire:loading wire:target="create">
                <i class="fa fa-spin fa-spinner btn-icon-prepend"></i>
                Đang mở...
                </span>
                </button>
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
                            </li>
                        </ul>
                        <form class="d-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                                <x-admin.input.text style="width: 400px" wire:model.live="search" placeholder="Tìm kiếm theo tên..."/>
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
                onSort="sortBy('name')" 
                direction="{{ $sortField === 'name' ? $sortDirection : 'desc' }}">
                Tên
            </x-admin.table.heading>
            <x-admin.table.heading>Loại danh mục</x-admin.table.heading>
            <x-admin.table.heading>Ảnh</x-admin.table.heading>
            <x-admin.table.heading>Danh mục cha</x-admin.table.heading>
            <x-admin.table.heading 
                sortable
                onSort="sortBy('created_at')" 
                direction="{{ $sortField === 'created_at' ? $sortDirection : 'desc' }}">
                Ngày tạo
            </x-admin.table.heading>
            <x-admin.table.heading>Hành động</x-admin.table.heading>
        </x-slot>

        <x-slot name="body">
            @forelse($categories as $category)
            <x-admin.table.row wire:loading.class="opacity-50">
                <x-admin.table.cell style="font-weight:bold">
                    {{ $category->name }}
                </x-admin.table.cell>
                <x-admin.table.cell style="font-weight:bold">
                    @if(array_key_exists($category->type, $types))
                        {{ $types[$category->type] }}
                    @else
                        {{ ucfirst($category->type) }}
                    @endif
                </x-admin.table.cell>
                <x-admin.table.cell>
                    <img src="{{ Storage::url($category->image) }}" alt="" srcset="" style="width: 50px;height: 50px; border-radius: 0px">
                </x-admin.table.cell>
                <x-admin.table.cell>
                    <label class="badge {{ $category->parent ? 'badge-info' : 'badge-warning' }}" style="font-weight: bold">
                        {{ $category->parent->name ?? 'Không có' }}
                    </label>                    
                </x-admin.table.cell>
                <x-admin.table.cell>
                    {{ $category->created_at }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    <button wire:click="edit({{ $category->id }})" type="button" class="btn btn-dark"> 
                    <i class="ti-file btn-icon-append"></i>
                    </button>
                    <button type="button" class="btn btn-danger"
                    @click=" confirm('Bạn chắc chắn muốn xóa danh mục này?') ? $wire.deleteCategory({{ $category->id }}) : false">
                        <i class="ti-trash btn-icon-append"></i>
                    </button>
                </x-admin.table.cell>
            </x-admin.table.row>
            @empty
            <x-admin.table.row>
                <x-admin.table.cell colspan="8" class="text-center">Không có danh mục nào</x-admin.table.cell>
            </x-admin.table.row>
            @endforelse
        </x-slot>
    </x-admin.table>
    
    <br>
    <!-- Pagination - Always Visible -->
    {{ $categories->links() }}
    
    @if($showEditModal)
        <x-modal wire:model="showEditModal">
            <x-slot name="title">{{ $mode === 'edit' ? 'Cập nhật danh mục' : 'Tạo danh mục mới' }}</x-slot>
            <div class="card-body">
            <form class="forms-sample" wire:submit.prevent="saveCategory" @keydown.enter="$event.target.tagName !== 'TEXTAREA' && $event.preventDefault(); $wire.saveCategory()">
                <div class="form-group">
                  <label>Tên</label>
                  <x-admin.input.text wire:model="categoryData.name"/>
                  @error('categoryData.name')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group">
                    <label>Slug</label>
                    <x-admin.input.text wire:model="categoryData.slug"/>
                    @error('categoryData.slug')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Danh mục cha</label>
                    <select wire:model="categoryData.parent_id" class="form-control">
                        <option value="">Vui lòng chọn</option>
                        @foreach($parentCategories as $parentCategory)
                            <option value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                        @endforeach
                    </select>
                    @error('categoryData.parent_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Loại danh mục (Chỉ dành cho danh mục con)</label>
                    <select wire:model="categoryData.type" class="form-control">
                        <option value="">Vui lòng chọn</option>
                        @foreach($types as $key => $name)
                            <option value="{{ $key }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('categoryData.type')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Ảnh</label>
                    <x-admin.input.file-upload wire:model="categoryData.image" :logo="$categoryData['image']">
                        <x-slot name="title">Tải ảnh lên</x-slot>
                    </x-admin.input.file-upload>
                    @error('categoryData.image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <x-slot name="footer">
                    <button type="submit" @click="$wire.saveCategory()" class="btn btn-primary me-2">Lưu</button>
                    <button type="button" x-on:click="show = false" @click="$dispatch('reset-form')" class="btn btn-light">Hủy</button>
                </x-slot>
              </form>
            </div>
        </x-modal>
    @endif

            </div>
          </div>
      </div>
    </div>
    
</div>
