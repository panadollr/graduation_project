<div class="tab-pane fade active show" id="product-review-tab" role="tabpanel" aria-labelledby="product-review-link">
    <!-- Form gửi đánh giá -->
    <style>
        /* Định dạng sao */
        .star {
            font-size: 30px;
            color: #ddd; /* Màu xám cho sao chưa được chọn */
            cursor: pointer;
            transition: color 0.3s;
        }

        .star.selected {
            color: gold; /* Màu vàng cho sao đã chọn */
        }
       
        textarea {
            resize: none;
            height: 30px; /* Đặt chiều cao cho ô textarea */
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            margin-top: 10px;
        }
    </style>

    <div class="reply">
        <div class="heading">
            <h3 class="title">Để lại đánh giá của bạn</h3><!-- End .title -->
        </div><!-- End .heading -->

        <center>
            <div class="form-group" x-data="{ rating: @entangle('rating'), tempRating: 0 }" >
                <label for="rating">Chọn đánh giá sao:</label>
                <div class="rating" wire:reset>
                    <template x-for="star in 5" :key="star">
                        <span 
                            class="star"
                            :class="{'selected': star <= tempRating || star <= rating}" 
                            @click="rating = star" 
                            @mouseover="tempRating = star" 
                            @mouseleave="tempRating = rating">
                            <i class="fa fa-star"></i>
                        </span>
                    </template>
                </div>
                <span x-text="rating > 0 ? `${rating} sao` : 'Chưa chọn'"></span>
                @error('rating') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            </center>

            <label for="reply-message" class="sr-only">Comment</label>
            <textarea name="reply-message" id="reply-message" cols="30" rows="4" class="form-control" required="" wire:model="comment" placeholder="Viết bình luận của bạn tại đây..."></textarea>
            <button @auth wire:click.prevent="submitReview" 
                @else href="#signin-modal" data-toggle="modal" 
                @endauth
                type="submit" class="btn btn-outline-primary-2">
                <span>GỬI ĐÁNH GIÁ</span>
                <i class="icon-long-arrow-right"></i>
            </button>
    </div><!-- End .reply -->

    <hr>
    <div class="comments">
        <h3 class="title">{{ count($reviews) }} Đánh giá</h3><!-- End .title -->
        <ul>
            @foreach ($reviews as $review)
            <li>
                <div class="comment">
                    <figure class="comment-media">
                        <a href="#">
                            <img src="{{ asset('client/assets/images/user-avatar.webp')}}" alt="User name">
                        </a>
                    </figure>

                    <div class="comment-body">
                        {{-- <a href="#" class="comment-reply">Reply</a> --}}
                        <div class="comment-user">
                            <h4><a href="#">{{ $review->user->name }}</a></h4>
                            
                                <div class="ratings">
                                    <div class="ratings-val" style="width: {{ $review->rating * 20 }}%;"></div>
                                </div>
                            
                            <span class="comment-date">{{ formatTimestamp($review->created_at) }}</span>
                        </div><!-- End .comment-user -->

                        <div class="comment-content">
                            <p>{{ $review->comment }}</p>
                        </div><!-- End .comment-content -->
                    </div><!-- End .comment-body -->
                </div><!-- End .comment -->
                
                <!-- Hiển thị bình luận con -->
                @if ($review->replies->count())
                <ul>
                    @foreach ($review->replies as $child)
                    <li>
                        <div class="comment">
                            <figure class="comment-media">
                                <a href="#">
                                    <img src="{{ asset('client/assets/images/user-avatar.webp')}}" alt="User name">
                                </a>
                            </figure>

                            <div class="comment-body">
                                <div class="comment-user">
                                    <h4>
                                        <a href="#">{{ $child->user->name }} 
                                            @if ($child->user->role === 'admin')
                                                (Quản trị viên)
                                            @elseif ($child->user->role === 'employee')
                                                (Nhân viên)
                                            @endif
                                        </a>
                                    </h4>
                                    <span class="comment-date">{{ formatTimestamp($child->created_at) }}</span>
                                </div><!-- End .comment-user -->
                                

                                <div class="comment-content mt-2">
                                    <p>{{ $child->comment }}</p>
                                </div><!-- End .comment-content -->
                            </div><!-- End .comment-body -->
                        </div><!-- End .comment -->
                    </li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endforeach
        </ul>
    </div><!-- End .comments -->
                    
    </div><!-- .End .tab-pane -->
