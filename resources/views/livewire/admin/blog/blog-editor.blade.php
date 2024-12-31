<div>
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('admin.blog.index') }}" class="btn btn-primary btn-sm me-3">
            <i class="fa fa-arrow-left me-1"></i> Danh sách bài viết
        </a>
        <h4 class="mb-0">{{ $title ?? '' }}</h4>
    </div>

        <div class="col-md-12">
            <!-- Card Header -->
            <div class="card shadow-sm mt-4">
                <!-- Form Start -->
                <div class="card-body">
                    <!-- Form -->
                    <form wire:submit.prevent="save">
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề</label>
                            <input type="text" wire:model="blogData.title" id="title" class="form-control @error('blogData.title') is-invalid @enderror" placeholder="Nhập tiêu đề bài viết">
                            @error('blogData.title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Slug -->
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" wire:model="blogData.slug" id="slug" class="form-control @error('blogData.slug') is-invalid @enderror" placeholder="Nhập slug bài viết">
                            @error('blogData.slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Hình ảnh</label>
                            <input type="file" wire:model="blogData.image" id="image" class="form-control @error('blogData.image') is-invalid @enderror">
                            @error('blogData.image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            
                            <!-- Image Preview -->
                            @if (isset($blogData['image']) && $blogData['image'])
                                <div class="mt-3">
                                    <img src="{{ $blogData['image'] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile ? $blogData['image']->temporaryUrl() : asset('storage/' . $blogData['image']) }}" alt="Hình ảnh bài viết" class="img-thumbnail" width="500">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3" wire:ignore>
                            <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
                            <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
                        
                            <label for="content" class="form-label">Nội dung</label>
                            <div id="content_editor" style="height: 600px;" @error('blogData.content') is-invalid @enderror"></div>
                            <script>
                                var quill1 = new Quill('#content_editor', {
                                    theme: 'snow'
                                });
                                quill1.clipboard.dangerouslyPasteHTML(@json($blogData['content']));
                                quill1.on('text-change', function() {
                                    const content = quill1.root.innerHTML;
                                    @this.set('blogData.content', content);
                                });
                            </script>
                           @error('blogData.content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select class="form-control" wire:model="blogData.status">
                                <option value="1">Hiển thị</option>
                                <option value="0">Ẩn</option>
                            </select>
                            @error('blogData.status') 
                                <div class="text-danger">{{ $message }}</div> 
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fa fa-save me-1"></i> Lưu bài viết
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Card End -->
        </div>
    </div>
