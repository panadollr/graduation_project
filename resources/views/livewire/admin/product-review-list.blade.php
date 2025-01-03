<div>
    <h4 class="card-title">Đánh giá sản phẩm</h4>
    <br>
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
                                <x-admin.input.text style="width: 400px" wire:model.live="search" placeholder="Tìm kiếm bình luận hoặc người dùng..."/>
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
                onSort="sortBy('created_at')" 
                direction="{{ $sortField === 'created_at' ? $sortDirection : 'desc' }}">
                Ngày đánh giá
            </x-admin.table.heading>
            <x-admin.table.heading>Người dùng</x-admin.table.heading>
            <x-admin.table.heading>Sản phẩm</x-admin.table.heading>
            <x-admin.table.heading>Đánh giá</x-admin.table.heading>
            <x-admin.table.heading>Nội dung bình luận</x-admin.table.heading>
            <x-admin.table.heading>Hành động</x-admin.table.heading>
        </x-slot>

        <x-slot name="body">
            @forelse ($reviews as $review)
            <x-admin.table.row wire:loading.class="opacity-50">
                <x-admin.table.cell style="font-weight:bold">
                    {{ $review->created_at  }}
                </x-admin.table.cell>
                <x-admin.table.cell>
                <h6>{{ $review->user->name }}</h6>
                </x-admin.table.cell>
                <x-admin.table.cell>
                    <a href="{{ route('product', ['product_slug' => $review->product->slug]) }}" target="_blank" style="text-decoration: underline;">{{ $review->product->name }}</a>
                </x-admin.table.cell>
                <x-admin.table.cell>
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $review->rating)
                        <i class="fa fa-star fa-lg text-warning"></i>
                    @else
                        <i class="fa fa-star-o fa-lg text-muted"></i> <!-- Ngôi sao rỗng -->
                    @endif
                @endfor
                </x-admin.table.cell>
                <x-admin.table.cell>
                    {{ $review->comment }}
                    
                    <!-- Hiển thị câu trả lời -->
                    @if($review->replies->count() > 0)
                    <div class="mt-2">
                        <ul class="list-group">
                            @foreach($review->replies as $reply)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold">{{ $reply->user->name }}
                                        @if ($reply->user->id === auth()->id())
                                            (Bạn) :
                                        @endif    
                                        </span> 
                                        {{ $reply->comment }}
                                        <br>
                                        <small class="text-muted">{{ $reply->created_at }}</small>
                                    </div>
                                    <button 
                                        wire:click="deleteReview({{ $reply->id }})" 
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Bạn có chắc muốn xóa câu trả lời này?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>                    
                    @else
                        <p class="text-muted">Chưa có câu trả lời.</p>
                    @endif
                </x-admin.table.cell>
                <x-admin.table.cell>                    
                    <!-- Trả lời -->
                    <button 
                        wire:click="openReplyModal({{ $review->id }})"
                        class="btn btn-info">
                        <i class="fa fa-mail-reply"></i> Trả lời
                    </button>
    
                    <!-- Xóa -->
                    <button 
                        wire:click="deleteReview({{ $review->id }})"
                        class="btn btn-danger"
                        onclick="return confirm('Bạn có chắc muốn xóa bình luận này?')">
                        <i class="fa fa-trash"></i> 
                        Xóa
                    </button>
                </x-admin.table.cell>
               
            </x-admin.table.row>
            @empty
            <x-admin.table.row>
                <x-admin.table.cell colspan="8" class="text-center">Không có bình luận nào</x-admin.table.cell>
            </x-admin.table.row>
            @endforelse
        </x-slot>
    </x-admin.table>
    
    <br>
    <!-- Pagination - Always Visible -->
    {{ $reviews->links() }}

    <!-- Modal trả lời -->
@if($showReplyModal)
<x-modal wire:model="showReplyModal">
    <x-slot name="title">Trả lời bình luận</x-slot>
    <div class="card-body">
        <form wire:submit.prevent="replyToComment">
            <div class="form-group">
                <textarea wire:model="replyComment" class="form-control" rows="4" placeholder="Nhập bình luận trả lời"></textarea>
            </div>
        </form>
    </div>
    <x-slot name="footer">
        <button type="submit" class="btn btn-primary me-2" wire:click="replyToComment">Trả lời</button>
        <button type="button" class="btn btn-light" wire:click="toggleReplyModal">Hủy</button>
    </x-slot>
</x-modal>
@endif

            </div>
          </div>
      </div>
    </div>
</div>
