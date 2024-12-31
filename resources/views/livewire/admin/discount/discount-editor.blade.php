<div>
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('admin.discount.index') }}" class="btn btn-primary btn-sm me-3">
            <i class="fa fa-arrow-left me-1"></i> Danh sách mã giảm giá
        </a>
        <h4 class="mb-0">{{ $title ?? '' }}</h4>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
    <form wire:submit.prevent="saveDiscount">
        <div class="form-group">
            <label>Mã giảm giá</label>
            <input type="text" class="form-control" wire:model.defer="discountData.code">
            @error('discountData.code') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Giảm giá (%)</label>
            <input type="number" class="form-control" wire:model.defer="discountData.discount_value">
            @error('discountData.discount_value') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group" 
        x-data="{
            minOrderValue: @entangle('discountData.min_order_value'),
        }" 
        x-init="minOrderValue = $money(this.minOrderValue, ',')">
            <label>Giá trị đơn hàng tối thiểu</label>
            <input type="text" class="form-control" 
            x-model="minOrderValue" 
            x-mask:dynamic="$money($input, ',')">
            @error('discountData.min_order_value') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Số lượng sử dụng</label>
            <input type="number" class="form-control" wire:model.defer="discountData.usage_limit">
            @error('discountData.usage_limit') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Ngày bắt đầu</label>
            <input type="datetime-local" class="form-control" wire:model.defer="discountData.start_date">
            @error('discountData.start_date') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Ngày kết thúc</label>
            <input type="datetime-local" class="form-control" wire:model.defer="discountData.end_date">
            @error('discountData.end_date') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Trạng thái</label>
            <select class="form-control" wire:model.defer="discountData.status">
                <option value="1">Hoạt động</option>
                <option value="0">Không hoạt động</option>
            </select>
            @error('discountData.status') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
                </div>
            </div>
        </div>
    </div>

</div>
