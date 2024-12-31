<div>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item me-4">
                        <h4 class="card-title">Danh sách Slider</h4>
                    </li>
                </ul>
                <a href="{{ route('admin.slider.create') }}" type="button" class="btn btn-primary btn-icon-text" >
                    <i class="ti-plus btn-icon-prepend"></i>
                    Thêm slider mới
                </a>
            </div>
        </div>
    </nav>

    <div class="row">
        <div class="col-lg-12">
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
                                        <x-admin.input.text style="width: 400px" wire:model="search" placeholder="Tìm kiếm slider..."/>
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
                                Ảnh slider
                            </x-admin.table.heading>
                            <x-admin.table.heading>
                                Tên slide
                            </x-admin.table.heading>
                            <x-admin.table.heading>
                                Mô tả
                            </x-admin.table.heading>
                            <x-admin.table.heading>
                                Trạng thái
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
                            @forelse($sliders as $slider)
                                <x-admin.table.row wire:loading.class="opacity-50">
                                    <x-admin.table.cell>
                                        {{ $slider->id }} 
                                    </x-admin.table.cell>
                                    <x-admin.table.cell>
                                        <img src="{{ $slider->image }}" style="width: 150px;height: 150px; border-radius: 0%; object-fit: contain"> 
                                    </x-admin.table.cell>
                                    <x-admin.table.cell>
                                        {{ Str::limit($slider->title, 50) }}
                                    </x-admin.table.cell>
                                    <x-admin.table.cell>
                                        {{ Str::limit($slider->description, 50) }}
                                    </x-admin.table.cell>
                                    <x-admin.table.cell>
                                        <label class="badge badge-opacity-{{ $slider->status ? 'success' : 'error' }} success" style="font-weight: bold;">
                                            {{ $slider->status ? 'Hiện' : 'Ẩn'}}
                                        </label>
                                    </x-admin.table.cell>
                                    <x-admin.table.cell>
                                        {{ $slider->created_at }}
                                    </x-admin.table.cell>
                                    <x-admin.table.cell>
                                        <a href="{{ route('admin.slider.edit', ['id' => $slider->id]) }}" type="button" class="btn btn-dark btn-icon-text"> 
                                            Sửa<i class="fa fa-edit btn-icon-append"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-icon-text"
                                        @click=" confirm('Bạn chắc chắn muốn xóa slider này?') ? $wire.delete({{ $slider->id }}) : false">
                                        Xóa<i class="fa fa-trash-o btn-icon-append"></i>
                                        </button>
                                    </x-admin.table.cell>
                                </x-admin.table.row>
                            @empty
                                <x-admin.table.row>
                                    <x-admin.table.cell colspan="7" class="text-center">Không có slider nào</x-admin.table.cell>
                                </x-admin.table.row>
                            @endforelse
                        </x-slot>
                    </x-admin.table>

                    <br>
                    <!-- Pagination - Always Visible -->
                    {{ $sliders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
