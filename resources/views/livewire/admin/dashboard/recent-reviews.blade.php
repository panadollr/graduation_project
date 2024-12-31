    <div class="card card-rounded">
        <div class="card-body card-rounded">
            <h4 class="card-title card-title-dash">Bình luận gần đây</h4>
            <div class="mt-3">
                @forelse ($recentReviews as $review)
                    <div class="list align-items-center border-bottom py-3">
                        <div class="d-flex">
                            <div class="wrapper w-100">
                                <!-- Tên người dùng và tên sản phẩm -->
                                <p class="mb-1 fw-bold">
                                    {{ $review->user->name }} đã bình luận về sản phẩm 
                                    <span class="text-primary">{{ limitString($review->product->name, 30) }}</span>
                                </p>
                                
                                <!-- Nội dung bình luận -->
                                <p class="mb-2 text-muted">
                                    "{{ limitString($review->comment, 80) }}" {{-- Giới hạn nội dung nếu quá dài --}}
                                </p>
                                
                                <!-- Thời gian bình luận -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-calendar text-muted me-1"></i>
                                        <p class="mb-0 text-small text-muted">
                                            {{ formatTimestamp($review->created_at) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center">Không có bình luận nào gần đây</p>
                @endforelse
            </div>

            <!-- Nút Xem tất cả -->
            <div class="list align-items-center pt-3">
                <div class="wrapper w-100">
                    <p class="mb-0">
                        <a href="#" class="fw-bold text-primary">Xem tất cả <i class="mdi mdi-arrow-right ms-2"></i></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
