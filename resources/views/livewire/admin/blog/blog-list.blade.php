<div>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item me-4">
                    <h4 class="card-title">Danh sách bài viết</h4>
                </li>
            </ul>
            <a href="{{ route('admin.blog.create') }}" type="button" class="btn btn-primary btn-icon-text" >
                <i class="ti-plus btn-icon-prepend"></i>
                Thêm mới bài viết
            </a>
        </div>
    </div>
  </nav>

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
                        <x-admin.input.text style="width: 400px" wire:model.live="search" placeholder="Tìm kiếm theo tên bài viết, nội dung..."/>
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
                #
            </x-admin.table.heading>
            <x-admin.table.heading>
                Tiêu đề
            </x-admin.table.heading>
            <x-admin.table.heading>
                Hình ảnh
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
            @forelse ($blogs as $key => $item)
            <x-admin.table.row wire:loading.class="opacity-50">
                <x-admin.table.cell>
                    {{ $blogs->firstItem() + $key }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    {{ $item->title }} 
                </x-admin.table.cell>
                <x-admin.table.cell>
                    <img src="{{ Storage::url($item->image) }} " style="width: 100%;height: 150px; border-radius: 0%; object-fit: contain">
                </x-admin.table.cell>
                <x-admin.table.cell>
                    {{ $item->created_at->format('d/m/Y') }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    <a class="btn btn-primary" href="{{ route('admin.blog.edit', $item->id) }}">Sửa</a>
                    
                    @if(auth()->user()->role == 'admin')
                    <button class="btn btn-danger" 
                        @click=" confirm('Bạn chắc chắn muốn bài viết này?') ? $wire.delete({{ $item->id }}) : false">Xóa
                    </button>
                    @endif
                </x-admin.table.cell>
            </x-admin.table.row>
            @empty
            <x-admin.table.row>
                <x-admin.table.cell colspan="8" class="text-center">Không có bài viết nào</x-admin.table.cell>
            </x-admin.table.row>
            @endforelse
        </x-slot>
    </x-admin.table>

    <div class="mt-4">
        {{ $blogs->links() }}
    </div>

</div>
</div>
</div>