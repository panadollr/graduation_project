<div>
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('admin.slider.index') }}" class="btn btn-primary btn-sm me-3">
            <i class="fa fa-arrow-left me-1"></i> Danh sách slider
        </a>
        <h4 class="mb-0">{{ $title ?? '' }}</h4>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample" wire:submit.prevent="saveSlider">
                            <div class="form-group">
                                <label for="title">Tên slider</label>
                                <input type="text" class="form-control" wire:model="sliderData.title">
                                @error('sliderData.title') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="featured_image">Ảnh đại diện</label>
                                <input type="file" class="form-control" wire:model="sliderData.image" accept="image/*">
                                @error('sliderData.image') <div class="text-danger">{{ $message }}</div> @enderror
                                @if ($sliderData['image'])
                                    <center>
                                        <div class="mt-3">
                                        <img src="{{ is_string($sliderData['image']) ? url($sliderData['image']) : $sliderData['image']->temporaryUrl() }}" class="img-fluid" style="max-width: 800px;">
                                    </div>
                                </center>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="link_url">Đường dẫn</label>
                                <input type="text" class="form-control" wire:model="sliderData.link_url">
                                @error('sliderData.link_url') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div wire:ignore>
                                <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
                                <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
                                <div class="form-group">
                                    <label>Mô tả </label>
                                    <textarea class="form-control" wire:model="sliderData.description" cols="30" rows="10"></textarea>
                                    @error('sliderData.description') <div class="text-danger">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary me-2" wire:click="saveSlider">Lưu</button>
        <a href="{{ route('admin.slider.index') }}" class="btn btn-light" type="button">Hủy</a>
    </div>
    <br>
</div>
