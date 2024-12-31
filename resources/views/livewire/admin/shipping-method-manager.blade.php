<div>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item me-4">
                        <h4 class="card-title">Hình thức vận chuyển</h4>
                    </li>
                </ul>
                <button wire:click="create" type="button" class="btn btn-primary btn-icon-text" 
                                        wire:loading.attr="disabled" wire:loading.class="loading">
                                    <i class="ti-plus btn-icon-prepend" wire:loading.remove wire:target="create"></i>
                                    <span wire:loading.remove wire:target="create">Thêm hình thức mới</span>
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
                Tên hình thức
            </x-admin.table.heading>
            <x-admin.table.heading 
            sortable
            onSort="sortBy('price')" 
            direction="{{ $sortField === 'price' ? $sortDirection : 'desc' }}">Giá tiền</x-admin.table.heading>
            <x-admin.table.heading>Tình trạng</x-admin.table.heading>
            <x-admin.table.heading>Mô tả</x-admin.table.heading>
            <x-admin.table.heading 
                sortable
                onSort="sortBy('created_at')" 
                direction="{{ $sortField === 'created_at' ? $sortDirection : 'desc' }}">
                Ngày tạo
            </x-admin.table.heading>
            <x-admin.table.heading>Hành động</x-admin.table.heading>
        </x-slot>

        <x-slot name="body">
            @forelse($shippingMethods as $method)
            <x-admin.table.row wire:loading.class="opacity-50">
                <x-admin.table.cell style="font-weight:bold">
                    {{ $method->name }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    {{ formatVND($method->price) }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    <label class="badge {{ $method->is_active ? 'badge-success' : 'badge-warning' }}" style="font-weight: bold">
                        {{ $method->is_active ? 'Hiện' : 'Ẩn' }}
                    </label>                    
                </x-admin.table.cell>
                <x-admin.table.cell>
                    {{ $method->description }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    {{ $method->created_at }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    <button wire:click="edit({{ $method->id }})" type="button" class="btn btn-dark btn-rounded btn-icon-text btn-sm"> 
                        Sửa 
                    <i class="ti-file btn-icon-append"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-rounded btn-icon-text btn-sm"
                    @click=" confirm('Bạn chắc chắn muốn xóa hình thức này?') ? $wire.delete({{ $method->id }}) : false">
                        Xóa 
                        <i class="ti-trash btn-icon-append"></i>
                    </button>
                </x-admin.table.cell>
            </x-admin.table.row>
            @empty
            <x-admin.table.row>
                <x-admin.table.cell colspan="6" class="text-center">Không có hình thức nào</x-admin.table.cell>
            </x-admin.table.row>
            @endforelse
        </x-slot>
    </x-admin.table>
    
    <br>
    <!-- Pagination - Always Visible -->
    {{ $shippingMethods->links() }}
    
    @if($showEditModal)
        <x-modal wire:model="showEditModal">
            <x-slot name="title">{{ $mode === 'edit' ? 'Cập nhật hình thức' : 'Tạo hình thức mới' }}</x-slot>
            <div class="card-body">
            <form class="forms-sample" wire:submit.prevent="save" @keydown.enter="$event.target.tagName !== 'TEXTAREA' && $event.preventDefault(); $wire.save()">
                <div class="form-group">
                    <label>Tên hình thức</label>
                  <x-admin.input.text wire:model="shippingMethodData.name"/>
                  @error('shippingMethodData.name')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group">
                    <label>Giá tiền (VNĐ)</label>
                    <x-admin.input.text wire:model="shippingMethodData.price" type="number" min="0"/>
                    @error('shippingMethodData.price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>    
                <div class="form-group">
                    <label>Tình trạng</label>
                    <select wire:model="shippingMethodData.is_active" class="form-control">
                        <option value="">Vui lòng chọn</option>
                        <option value="1">Hiện</option>
                        <option value="0">Ẩn</option>
                    </select>
                    @error('shippingMethodData.is_active')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Mô tả (Không bắt buộc)</label>
                    <textarea class="form-control" rows="10" wire:model="shippingMethodData.description"></textarea>
                    @error('shippingMethodData.description')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>       
                <x-slot name="footer">
                    <button type="submit" @click="$wire.save()" class="btn btn-primary me-2">Lưu</button>
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
