<div>    
        <br>
        <div class="row">
                <style>
        /* Bố cục chung */
        .form-section {
            margin-bottom: 20px;
            padding: 15px;
            /* background-color: #f9f9f9; */
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .form-section .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-control {
            border-radius: 5px;
            padding: 10px;
            font-size: 14px;
        }
    </style>
            <div class="col-lg-7">
                {{-- <h2 class="checkout-title">Chi tiết thanh toán</h2> --}}
                <div class="form-section" style="background-color: #f8f9fc; border: 1px solid #ddd; padding: 15px; border-radius: 8px;">
                    <!-- Địa chỉ giao hàng -->
                    <h3 class="section-title" style="color: #1f3bb3; font-weight: bold; margin-bottom: 20px;">Địa chỉ giao hàng</h3>
                    <div class="form-group">
                        @if(!$addresses->isEmpty())
                        <label for="shipping_address" style="color: #1f3bb3; font-weight: bold;">Chọn địa chỉ giao hàng:</label>
                        <select 
                            class="form-control" 
                            id="shipping_address" 
                            wire:model.defer="selectedAddress"
                            style="border: 2px solid #1f3bb3; border-radius: 6px; padding: 10px; color: #333;">
                            @foreach ($addresses as $address)
                                <option value="{{ $address->id }}">
                                    {{ $address->name }} - {{ $address->phone }} - <p class="address-paragraph">{{ $address['address'] }}</p>
                                    {{-- <p class="address-paragraph">
                                        {{ collect($phuongList[$address->district] ?? [])->firstWhere('id', $address->ward)['full_name'] ?? 'Không xác định' }},
                                        {{ collect($quanList[$address['city']] ?? [])->firstWhere('id', $address['district'])['full_name'] ?? 'Không xác định' }},
                                       
                                    </p> --}}
                                    
                                </option>
                            @endforeach
                        </select>
                        @else
                        <div class="alert alert-danger" style="background-color: #ffc9c9; color: #b31f1f; border: 1px solid #b31f1f;">
                            Bạn chưa có địa chỉ giao hàng. Vui lòng thêm địa chỉ trước khi thanh toán!
                        </div>
                        @endif
                    </div>
                    <a wire:navigate href="{{ route('account.address.index') }}" 
                       class="btn btn-link" 
                       style="color: #1f3bb3; font-weight: bold; text-decoration: underline;">
                        Thêm địa chỉ mới
                    </a>
                </div>              

                <!-- Danh sách mã giảm giá -->
                <div class="form-section" style="background-color: #f8f9fc; border: 1px solid #ddd; padding: 15px;">
                    <h3 class="section-title" style="color: #1f3bb3; font-weight: bold; margin-bottom: 15px;">Danh sách mã giảm giá</h3>
                    <div class="discount-list">
                        @if ($discounts->isEmpty())
                            <div class="alert alert-warning" style="background-color: #fff6d6; color: #b38f00; border: 1px solid #b38f00; border-radius: 6px;">
                                Hiện không có mã giảm giá nào khả dụng.
                            </div>
                        @else
                            <ul class="list-group" style="list-style: none; padding-left: 0;">
                                @foreach ($discounts as $discount)
                                    <li class="list-group-item d-flex justify-content-between align-items-center" style="border: 1px solid #1f3bb3; border-radius: 6px; margin-bottom: 10px; padding: 7px;">
                                        <div>
                                            <strong style="color: #1f3bb3;">{{ $discount->code }}</strong> 
                                            <span style="color: #333;">- Giảm {{ (int) $discount->discount_value }}%</span>
                                            <p style="margin: 5px 0 10px; color: #666;">Giá trị đơn hàng tối thiểu: {{ formatVND($discount->min_order_value) }}</p>
                
                                            <!-- Thanh progress -->
                                            <div class="progress" style="height: 30px; border-radius: 5px; overflow: hidden; background-color: #ddd;">
                                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                                                    style="width: {{ $discount->usage_limit > 0 
                                                        ? min(100, (100 * $discount->used_count) / $discount->usage_limit) 
                                                        : 0 }}%;"
                                                    aria-valuenow="{{ $discount->used_count }}" 
                                                    aria-valuemin="0" 
                                                    aria-valuemax="{{ $discount->usage_limit }}">
                                                   <span style="color: black; font-size: 12px; font-weight: bold; margin-left: 10px"> {{ $discount->used_count }} / {{ $discount->usage_limit }} đã sử dụng </span>
                                                </div>
                                            </div>
                                        </div>
                                        <button 
                                            class="btn btn-sm" 
                                            style="background-color: #1f3bb3; color: #fff; font-weight: bold; border: none; border-radius: 6px;"
                                            :disabled="{{ $estimatedTotal < $discount->min_order_value ? 'true' : 'false' }}"
                                            @click="
                                                if (navigator.clipboard && navigator.clipboard.writeText) {
                                                    navigator.clipboard.writeText('{{ $discount->code }}')
                                                        .then(() => toastr.success('Đã sao chép mã: {{ $discount->code }}'))
                                                        .catch(err => console.error('Lỗi khi sao chép: ', err));
                                                } else {
                                                    fallbackCopyTextToClipboard('{{ $discount->code }}');
                                                }
                                            ">
                                            Sao chép
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                
                <script>
                    function fallbackCopyTextToClipboard(text) {
                        const textArea = document.createElement("textarea");
                        textArea.value = text;
                        textArea.style.position = "fixed"; // Đảm bảo textarea không gây ảnh hưởng giao diện
                        document.body.appendChild(textArea);
                        textArea.focus();
                        textArea.select();
                        try {
                            document.execCommand('copy');
                            toastr.success('Đã sao chép mã: ' + text);
                        } catch (err) {
                            console.error('Lỗi khi sao chép: ', err);
                            toastr.error('Không thể sao chép mã.');
                        }
                        document.body.removeChild(textArea);
                    }
                </script>     
                
                <!-- Ghi chú đơn hàng -->
                <div class="form-section" style="background-color: #f8f9fc; border: 1px solid #ddd; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <h3 class="section-title" style="color: #1f3bb3; font-weight: bold; margin-bottom: 15px;">Ghi chú đơn hàng (tùy chọn)</h3>
                    <div class="form-group">
                        <label for="order_notes" style="color: #1f3bb3; font-weight: bold;">Ghi chú:</label>
                        <textarea  
                            class="form-control" 
                            wire:model.defer="note"
                            cols="30" 
                            style="min-height: 80px; border: 2px solid #1f3bb3; border-radius: 6px; padding: 10px; color: #333;"
                            placeholder="Ghi chú về đơn hàng của bạn, ví dụ: yêu cầu đặc biệt cho giao hàng."></textarea>
                    </div>
                </div>  
                
            </div>
            
            <aside class="col-lg-5">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                                {{ $error }}
                        @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="summary">
                    <h3 class="summary-title"><strong>Đơn hàng của bạn</strong></h3>

                    <table class="table table-summary">
                        <thead>
                            <tr>
                                <th><strong>Sản phẩm</strong></th>
                                <th>Giá tiền </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($checkoutProducts as $product)
                                <tr>
                                    <td>
                                        <a href="{{ route('product', ['product_slug' => $product['slug']]) }}">
                                            {{ Str::limit($product['name'], 50) }}
                                        </a>
                                        <br>Số lượng: {{ $product['quantity'] }}
                                    </td>
                                    <td>{{ formatVND($product['sale_price']) }} x {{ $product['quantity'] }} <br> => {{ formatVND($product['sale_price'] * $product['quantity']) }}</td>
                                </tr>
                            @endforeach
                            
                            <tr class="summary-shipping">
                                <td><strong>Vận chuyển</strong></td>
                                <td>Giá tiền</td>
                            </tr>
                            @foreach($shippingMethods as $index => $method)
                            <tr class="summary-shipping-row">
                                <td>
                                  <div class="custom-control custom-radio">
                                    <input type="radio" id="{{ $index }}" name="shipping" wire:model.live="selectedShipping" value="{{ $method->id }}"  class="custom-control-input">
                                    <label class="custom-control-label" for="{{ $index }}">{{ $method->name }}</label>
                                  </div>
                                  <!-- End .custom-control -->
                                </td>
                                <td>{{ formatVND($method->price) }}</td>
                            </tr>
                            @endforeach
                            
                            <tr class="summary-subtotal">
                                <td><strong>Tạm tính:</strong></td>
                                <td>{{ formatVND($subTotal) }}</td>
                            </tr>

                            @if($appliedDiscount)
                            <tr class="summary-subtotal">
                                <td><strong>Mã giảm giá: </strong></td>
                                <td> (-{{ (int) $appliedDiscount->discount_value }}%) 
                                    <br>
                                    - {{ formatVND($subTotal * ($appliedDiscount->discount_value / 100)) }}
                                </td>
                            </tr>
                            @endif

                            <tr >
                                <div class="form-section" style="background-color: #f8f9fc;  border: 1px solid #ddd;">
                                    <h3 class="section-title" style="color: #1f3bb3; font-weight: bold; margin-bottom: 15px;">Nhập mã giảm giá (nếu có)</h3> 
                                    <div class="input-group">
                                        <input style="border: 2px solid #1f3bb3; padding: 10px; color: #333;" type="text" class="form-control" wire:model="discountCode" required="" placeholder="Nhập mã giảm giá tại đây..">
                                        <div class="input">
                                          <button class="btn btn-primary" wire:click="applyDiscount" style="margin-left: 5px">
                                            Áp dụng<i class="icon-long-arrow-right"></i>
                                          </button>
                                        </div>
                                        <!-- .End .input-group-append -->
                                      </div>
                                      <!-- End .input-group -->
                                      @if($appliedDiscount)
                                    <div class="alert alert-success" style="margin-top: 15px; border-radius: 6px; font-size: 1.4rem;">
                                        <strong>Thành công!</strong> Đã áp dụng mã giảm giá: 
                                        <span style="font-weight: bold;">{{ $appliedDiscount->code }}</span> - Đã giảm: 
                                        <span >{{ (int) $appliedDiscount->discount_value }}%</span>.
                                    </div>
                                @endif
                                  </div>
                            </tr>

                            <tr class="summary-total">
                                <td><strong>Tổng cộng:</strong></td>
                                <td>{{ number_format($estimatedTotal, 0, ',', '.') }}đ</td>
                            </tr>
                        </tbody>
                    </table>


                    <div class="btn-group btn-group-toggle btn-block" role="group" aria-label="Payment options">
                        <!-- Thanh toán khi nhận hàng -->
                        <button class="btn btn-outline-primary-2 btn-order" 
                                data-bs-toggle="modal" data-bs-target="#confirmModal" 
                                @click=" confirm('Bạn có chắc chắn muốn đặt hàng không ?') ? $wire.submitOrder('cod') : false"
                                @if($addresses->isEmpty()) disabled @endif>
                            <span class="btn-text">Thanh toán khi nhận hàng</span>
                            <span class="btn-hover-text">Tiến hành thanh toán</span>
                        </button>
                    
                        <!-- Thanh toán VNPay -->
                        <button class="btn btn-outline-primary-2 btn-order" 
        data-bs-toggle="modal" data-bs-target="#confirmModal" 
        @click="confirm('Bạn có chắc chắn muốn đặt hàng không ?') ? $wire.submitOrder('vnpay') : false"
        @if($addresses->isEmpty()) disabled @endif>
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTp1v7T287-ikP1m7dEUbs2n1SbbLEqkMd1ZA&s" alt="VNPay" class="btn-icon" style="height: 30px"/>
    <span class="btn-text">Thanh toán VNPay</span>
    <span class="btn-hover-text">Tiến hành thanh toán</span>
</button>

                    </div>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmModalLabel">Xác nhận đặt hàng</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc chắn muốn đặt hàng với phương thức thanh toán đã chọn không?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="button" class="btn btn-primary" id="confirmOrderButton">Xác nhận</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </aside>
        </div>
</div>
