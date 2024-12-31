<?php

namespace App\Livewire\Admin;

use App\Models\ProductReview;
use Livewire\Component;
use Livewire\WithPagination;

class ProductReviewList extends Component
{
    use WithPagination;

    public $search = ''; // Tìm kiếm theo bình luận hoặc tên người dùng
    public $sortField = 'created_at'; // Trường sắp xếp
    public $sortDirection = 'desc'; // Hướng sắp xếp

    public $showReplyModal = false;  // Để kiểm tra trạng thái của modal
    public $replyComment = '';       // Nội dung bình luận trả lời
    public $reviewToReply;           // ID review đang trả lời

    public function render()
    {
        $reviews = ProductReview::with(['user', 'product'])
            ->whereNull('parent_id')
            ->when($this->search, function ($query) {
                $query->where('comment', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.product-review-list', [
            'reviews' => $reviews,
        ])
        ->extends('admin.app')
        ->layoutData(['title' => 'Đánh giá sản phẩm']);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function toggleVisibility($review)
    {
        $review->is_visible = !$review->is_visible;
        $review->save();
    }

    public function openReplyModal($id)
    {
        $this->reviewToReply = ProductReview::findOrFail($id);
        $this->showReplyModal = true;
    }

    public function toggleReplyModal(){
        $this->showReplyModal = !$this->showReplyModal;
    }

    public function replyToComment()
    {
        $newReply = new ProductReview();
        $newReply->user_id = auth()->id(); 
        $newReply->product_id = $this->reviewToReply->product_id;
        $newReply->rating = null; 
        $newReply->comment = $this->replyComment; 
        $newReply->parent_id = $this->reviewToReply->id; 

        // Lưu bình luận trả lời
        $newReply->save();

        // Đóng modal sau khi trả lời
        $this->showReplyModal = false;

        // Reset nội dung bình luận
        $this->replyComment = '';
    }

    public function deleteReview($id)
    {
        ProductReview::findOrFail($id)->delete();
        $this->js('showToast("Xóa đánh giá thành công !", "success")');
    }
}
