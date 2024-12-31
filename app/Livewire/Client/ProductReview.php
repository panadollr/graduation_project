<?php

namespace App\Livewire\Client;

use App\Models\ProductReview as ModelsProductReview;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ProductReview extends Component
{
    use WithPagination;

    public $productId; // ID của sản phẩm
    public $rating = 0; // Điểm đánh giá
    public $comment = ''; // Nội dung bình luận

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|min:3|max:500',
    ];

    public function mount($productId)
    {
        $this->productId = $productId;
    }

    public function submitReview()
    {
        $this->validate();

        if (!Auth::check()) {
            $this->js("toastr.error('Bạn cần đăng nhập để gửi đánh giá.')");
            return;
        }

        ModelsProductReview::create([
            'user_id' => Auth::id(),
            'product_id' => $this->productId,
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        $this->rating = 0;
        $this->comment = '';
        $this->js("toastr.success('Đánh giá của bạn đã được gửi.')");
    }

    public function render()
    {
        $reviews = ModelsProductReview::where('product_id', $this->productId)
        ->whereNull('parent_id')
        ->with('replies')
        ->latest()
        ->paginate(5);

        return view('livewire.client.product-review', [
            'reviews' => $reviews, // Phân trang, 5 đánh giá mỗi trang
        ]);
    }
}
