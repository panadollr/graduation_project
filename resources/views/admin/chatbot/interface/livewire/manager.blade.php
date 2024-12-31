<div>
    @include('layouts.toast')
    <h4 class="card-title">Quản lý giao diện Chatbot</h4>
    <br>
    <div class="row">                 
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample" wire:submit.prevent="saveChatbotSettings">
                        <div class="form-group">
                            <label>Tên Chatbot</label>
                            <x-admin.input.text wire:model="chatbotData.name" placeholder="Nhập tên chatbot"/>
                            @error('chatbotData.name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Logo Chatbot</label>
                            <x-admin.input.file-upload wire:model="chatbotData.logo" :logo="$chatbotData['logo']">
                                <x-slot name="title">Tải logo lên</x-slot>
                            </x-admin.input.file-upload>
                            @if($logoPreview)
                                <div class="mt-3">
                                    <label>Preview Logo:</label>
                                    <img src="{{ $logoPreview }}" alt="Preview Logo" class="img-fluid rounded" style="max-height: 150px;"/>
                                </div>
                            @endif
                            @if($chatbotData['logo'])
                                <button type="button" class="btn btn-danger mt-2" wire:click="deleteLogo">Xóa Logo Hiện Tại</button>
                            @endif
                            @error('chatbotData.logo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary me-2">Lưu</button>
                        <button type="button" class="btn btn-light" wire:click="resetForm">Hủy</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
