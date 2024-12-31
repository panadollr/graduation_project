<div>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item me-4">
                        <h4 class="card-title">Danh sách mã giảm giá</h4>
                    </li>
                </ul>
                <a href="{{ route('admin.discount.create') }}" type="button" class="btn btn-primary btn-icon-text" >
                    <i class="ti-plus btn-icon-prepend"></i>
                    Thêm mới mã giảm giá
                </a>
            </div>
        </div>
      </nav>

      <div class="row">                 
        <div class="col-lg-12 ">
          <div class="card">
            <div class="card-body">

    <div class="mb-4">
        <input type="text" class="form-control" placeholder="Tìm kiếm mã giảm giá..." wire:model.live="search">
    </div>

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
                Mã giảm giá
            </x-admin.table.heading>
            <x-admin.table.heading>
                Phần trăm giảm giá
            </x-admin.table.heading>
            <x-admin.table.heading
                sortable
                onSort="sortBy('min_order_value')" 
                direction="{{ $sortField === 'min_order_value' ? $sortDirection : 'desc' }}">
                Giá trị đơn hàng tối thiểu
            </x-admin.table.heading>
            <x-admin.table.heading>
                Số lần sử dụng
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
            @forelse ($discounts as $discount)
            <x-admin.table.row wire:loading.class="opacity-50">
                <x-admin.table.cell>
                    {{ $discount->id }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    {{ $discount->code }} 
                </x-admin.table.cell>
                <x-admin.table.cell>
                    {{ $discount->discount_value }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    {{ formatVND($discount->min_order_value) }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    {{ $discount->used_count }}/{{ $discount->usage_limit ?? 'Không giới hạn' }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    {{ $discount->status ? 'Hoạt động' : 'Không hoạt động' }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    {{ $discount->created_at }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                    <a class="btn btn-sm btn-primary" href="{{ route('admin.discount.edit', $discount->id) }}">Sửa</a>
                    <button class="btn btn-sm btn-danger" 
                        @click=" confirm('Bạn chắc chắn muốn xóa màu này?') ? $wire.deleteDiscount({{ $discount->id }}) : false">Xóa
                    </button>
                </x-admin.table.cell>
            </x-admin.table.row>
            @empty
            <x-admin.table.row>
                <x-admin.table.cell colspan="10" class="text-center">Không có mã nào</x-admin.table.cell>
            </x-admin.table.row>
            @endforelse
        </x-slot>
    </x-admin.table>

    <div class="mt-4">
        {{ $discounts->links() }}
    </div>

            </div></div></div></div>
</div>
