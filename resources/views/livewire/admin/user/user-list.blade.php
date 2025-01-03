<div>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item me-4">
                        <h4 class="card-title">Danh sách người dùng</h4>
                    </li>
                </ul>
                <a href="{{ route('admin.user.create') }}" type="button" class="btn btn-primary btn-icon-text" >
                    <i class="ti-plus btn-icon-prepend"></i>
                    Thêm người dùng mới
                </a>
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

                        </ul>
                        <form class="d-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                                <x-admin.input.text style="width: 400px" wire:model.live="search" placeholder="Tìm kiếm người dùng..."/>
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
            <x-admin.table.heading>Email</x-admin.table.heading>
            <x-admin.table.heading>
                Tên người dùng
            </x-admin.table.heading>
            <x-admin.table.heading sortable
            onSort="sortBy('role')" 
            direction="{{ $sortField === 'role' ? $sortDirection : 'desc' }}">Quyền</x-admin.table.heading>
            <x-admin.table.heading 
                sortable
                onSort="sortBy('created_at')" 
                direction="{{ $sortField === 'created_at' ? $sortDirection : 'desc' }}">
                Ngày tạo
            </x-admin.table.heading>
            <x-admin.table.heading>Hành động</x-admin.table.heading>
        </x-slot>

        <x-slot name="body">
            @forelse($users as $user)
            <x-admin.table.row wire:loading.class="opacity-50">
                <x-admin.table.cell>
                    {{ $user->id }}
                </x-admin.table.cell>
                <x-admin.table.cell style="font-weight:bold">
                    {{ $user->email }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    {{ $user->name }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    <!-- Hiển thị vai trò bằng nhãn -->
                    <span class="badge {{ $user->getRoleBadgeClass() }}">
                        @if ($user->role === 'admin')
                            Quản trị viên
                        @elseif ($user->role === 'employee')
                            Nhân viên
                        @elseif ($user->role === 'user')
                            Khách hàng
                        @endif
                    </span>
                </x-admin.table.cell>
                <x-admin.table.cell>
                    {{ $user->created_at }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    <button wire:navigate href="{{ route('admin.user.edit', $user->id )}}" type="button" class="btn btn-dark btn-rounded btn-icon-text btn-sm"> 
                        Sửa 
                    <i class="ti-file btn-icon-append"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-rounded btn-icon-text btn-sm"
                    @click=" confirm('Bạn chắc chắn muốn xóa người dùng này?') ? $wire.deleteCategory({{ $user->id }}) : false">
                        Xóa 
                        <i class="ti-trash btn-icon-append"></i>
                    </button>
                </x-admin.table.cell>
            </x-admin.table.row>
            @empty
            <x-admin.table.row>
                <x-admin.table.cell colspan="5" class="text-center">Không có người dùng nào</x-admin.table.cell>
            </x-admin.table.row>
            @endforelse
        </x-slot>
    </x-admin.table>
    
    <br>
    <!-- Pagination - Always Visible -->
    {{ $users->links() }}
    
    @if($showEditModal)
        <x-modal wire:model="showEditModal">
            <x-slot name="title">{{ $mode === 'edit' ? 'Cập nhật người dùng' : 'Tạo người dùng mới' }}</x-slot>
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
                    <label>người dùng cha</label>
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
