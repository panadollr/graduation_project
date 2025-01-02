<div>
        <div class="d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #1f3bb3;
            padding-bottom: 10px;
            margin-bottom: 20px;">
            <h6 class="fw-bold text-primary">Địa chỉ của tôi</h6>
            <button wire:click="openModal" class="btn btn-primary d-flex align-items-center gap-2">
                <span>Thêm địa chỉ mới</span>
                <i class="icon-plus"></i>
            </button>
        </div>

    <table class="table table-cart table-mobile" style="margin-top: -20px">
        <tbody>
            @foreach ($addresses as $address)
          <tr>
            <td class="product-col">
              <div class="product">
                <h3 class="product-title">
                  <a href="#">{{ $address['name'] }} | <span class="text-muted"> {{ $address['phone'] }}</span></a>
                  <style>
                    .address-paragraph {
                        margin: 5px 0;
                    }
                </style>
                
                <p class="address-paragraph">
                    {{ $address['address'] }}, {{ $address->ward_name}}, {{ $address->district_name}}, {{ $address->city_name }}
                </p>
                  @if ($address['is_default'])
                    <span style="border: 2px solid #28a745; color: #28a745;" class="badge">Mặc định</span>
                  @endif
                </h3>
                <!-- End .product-title -->
              </div>
              <!-- End .product -->
            </td>
            <td>
                <button wire:click="editAddress({{ $address['id'] }})" class="btn btn-primary" wire:loading.attr="disabled">
                    <span>Cập nhật</span>
                    <i class="fas fa-edit"></i>                    
                </button>
                @if (count($addresses)  == 1 || !$address['is_default'])
                <button wire:click="deleteAddress({{ $address['id'] }})" class="btn btn-danger">
                    <span>Xóa</span>
                    <i class="fas fa-trash"></i>
                </button>
                @endif
                @if (!$address['is_default'])
                <button wire:click="setDefaultAddress({{ $address['id'] }})" class="btn btn-outline-success">
                    <span>Thiết lập mặc định</span>
                    <i class="fas fa-check-circle"></i>
                </button>
                @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

    <!-- Modal thêm hoặc sửa địa chỉ -->
    @if ($isModalOpen)
        <!-- Modal thêm hoặc sửa địa chỉ -->
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $modalTitle }}</h5>
                        <button type="button" class="close" wire:click="closeModal">
                            <span aria-hidden="true">X</span>
                          </button>
                    </div>
                    <div class="modal-body" style="padding: 20px">
                        <form wire:submit.prevent="saveAddress">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Tên người nhận</label>
                                <input type="text" class="form-control" wire:model.defer="name">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phoneInput" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" wire:model.defer="phone">
                                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">                                
                                    <!-- Chọn tỉnh thành -->
                                    <label class="form-label">Tỉnh Thành</label>
                                    <select wire:model.live="tinh"  class="form-control" title="Chọn Tỉnh Thành">
                                        <option value="0">Tỉnh Thành</option>
                                        @foreach($tinhList as $tinh)
                                            <option value="{{ $tinh['id'] }}">{{ $tinh['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('tinh') <span class="text-danger">{{ $message }}</span> @enderror
                                    <div wire:loading wire:target="tinh">
                                        <span class="spinner-border spinner-border-sm"></span>
                                    </div>
                                    
                                    <!-- Chọn quận huyện -->
                                    <label class="form-label">Quận huyện</label>
                                    <select wire:model.live="quan" class="form-control" title="Chọn Quận Huyện">
                                        <option value="0">Quận Huyện</option>
                                        @foreach($quanList as $quan)
                                            <option value="{{ $quan['id'] }}">{{ $quan['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('quan') <span class="text-danger">{{ $message }}</span> @enderror
                                    <div wire:loading wire:target="quan">
                                        <span class="spinner-border spinner-border-sm"></span>
                                    </div>
                                    
                                    <!-- Chọn phường xã -->
                                    <label class="form-label">Phường / Xã</label>
                                    <select wire:model="phuong" class="form-control" title="Chọn Phường Xã">
                                        <option value="0">Phường Xã</option>
                                        @foreach($phuongList as $phuong)
                                            <option value="{{ $phuong['id'] }}">{{ $phuong['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('phuong') <span class="text-danger">{{ $message }}</span> @enderror
                               
                                <label class="form-label">Địa chỉ cụ thể</label>
                                <input type="text" class="form-control" wire:model.defer="address">
                                @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">{{ $saveButtonText }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

 
</div>
