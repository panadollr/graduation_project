<?php

namespace App\Livewire\Admin\Product;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\Log;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ProductEditor extends Component
{
    use WithFileUploads;

    public $productData = [
        'name' => '', 
        'slug' => '',
        'base_price' => 0,
        'sale_price' => 0,
        'short_description' => '',
        'description' => '',
        'category_id' => '',
        'featured_image' => null,  // Trường ảnh đại diện
        'additional_images' => [], // Trường ảnh phụ
        'quantity' => 0,
        'stock' => 0,
        'discount_percentage' => 0,
        'status' => 1,
    ];

    protected function rules()
    {
        $rules = [
            'productData.name' => 'required|string|max:255',
            'productData.slug' => 'required|string|max:255|unique:products,slug,' . ($this->productId ?? 'NULL'),
            'productData.base_price' => 'required|numeric|min:1000',
            'productData.category_id' => 'required|exists:categories,id',
            'productData.quantity' => 'required|numeric|min:1',
        ];

        if (!isset($this->productId)) {
            $rules['productData.featured_image'] = 'required|image';
        } else {
            $rules['productData.featured_image'] = 'nullable';
        }
    
        return $rules;
    }   
    
    public function messages()
    {
        return [
            'productData.name.required' => 'Tên sản phẩm là bắt buộc.',
            'productData.name.string' => 'Tên sản phẩm phải là chuỗi ký tự.',
            'productData.name.max' => 'Tên sản phẩm không được dài quá 255 ký tự.',
            
            'productData.slug.required' => 'Slug sản phẩm là bắt buộc.',
            'productData.slug.string' => 'Slug sản phẩm phải là chuỗi ký tự.',
            'productData.slug.unique' => 'Slug này đã tồn tại, vui lòng chọn slug khác.',
            'productData.slug.max' => 'Slug sản phẩm không được dài quá 255 ký tự.',
            
            'productData.category_id.required' => 'Danh mục sản phẩm là bắt buộc.',
            'productData.category_id.exists' => 'Danh mục sản phẩm không hợp lệ.',

            'productData.base_price.required' => 'Giá gốc là bắt buộc.',
            'productData.base_price.numeric' => 'Giá gốc phải là một số.',
            'productData.base_price.min' => 'Giá gốc phải lớn hơn hoặc bằng 1000.',

            'productData.sale_price.numeric' => 'Giá bán phải là một số.',
            'productData.sale_price.min' => 'Giá bán phải lớn hơn hoặc bằng 0.',

            'productData.discount_percentage.numeric' => 'Giảm giá phải là một số.',
            'productData.discount_percentage.min' => 'Giảm giá không được nhỏ hơn 0.',
            'productData.discount_percentage.max' => 'Giảm giá không được lớn hơn 100.',

            'productData.featured_image.required' => 'Ảnh đại diện sản phẩm là bắt buộc',
            'productData.featured_image.image' => 'Tệp tải lên phải là hình ảnh.',

            'productData.quantity.required' => 'Số lượng sản phẩm là bắt buộc.',
            'productData.quantity.numeric' => 'Số lượng sản phẩm phải là một số.',
            'productData.quantity.min' => 'Số lượng sản phẩm phải lớn hơn 0.',
        ];
    }
    
    public $categories;
    public $productId = null; // Sử dụng để xác định xem đang tạo mới hay chỉnh sửa

    public function mount($id = null)
    {
        $this->categories = Category::all();
        if ($id) {
            $product = Product::findOrFail($id);
            $this->productId = $product->id;
            $this->productData = $product->toArray();
            $this->productData['additional_images'] = json_decode($product->additional_images, true) ?? [];
        }
    }
    
    public function removeProductImage($index)
    {
        if (isset($this->productData['additional_images'][$index])) {
            $imagePath = $this->productData['additional_images'][$index];

            if (is_string($imagePath) && Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }

            unset($this->productData['additional_images'][$index]);
            $this->productData['additional_images'] = array_values($this->productData['additional_images']);
        }
    }

    public function handleImageUpload(){}

    public function saveProduct()
    {
        $this->productData['base_price'] = (int) str_replace('.', '', $this->productData['base_price']);
        $this->productData['sale_price'] = (int) str_replace('.', '', $this->productData['sale_price']);
        $this->validate();

        // Tự động gán stock = quantity (nếu không phải chỉnh sửa)
        if (!$this->productId) {
            $this->productData['stock'] = $this->productData['quantity'];
        }

        // Xử lý upload ảnh đại diện
        $featuredImage = $this->productData['featured_image'];
        if ($featuredImage instanceof TemporaryUploadedFile) {
            $featuredImagePath = $featuredImage->storeAs('products', uniqid() . '.webp', 'public');
            $this->productData['featured_image'] = Storage::url($featuredImagePath);
        } elseif ($this->productId && is_string($featuredImage)) {
            // Nếu chỉnh sửa và ảnh đại diện là đường dẫn cũ thì giữ nguyên
            $this->productData['featured_image'] = $featuredImage;
        } else {
            $this->productData['featured_image'] = null;
        }

        // Xử lý upload ảnh phụ
        $additionalImagePaths = [];
        foreach ($this->productData['additional_images'] as $image) {
            if ($image instanceof TemporaryUploadedFile) {
                // Upload file mới
                $imagePath = $image->storeAs('products', uniqid() . '.webp', 'public');
                $additionalImagePaths[] = Storage::url($imagePath);
            } elseif (is_string($image)) {
                // Giữ lại ảnh cũ (nếu là đường dẫn)
                $additionalImagePaths[] = $image;
            }
        }

        // Gán lại danh sách ảnh (cũ + mới)
        $this->productData['additional_images'] = json_encode($additionalImagePaths);

        $product = Product::updateOrCreate(
            ['id' => $this->productId],
            $this->productData
        );

        $message = $this->productId 
        ? "Đã cập nhật sản phẩm có ID: $this->productId" 
        : "Đã thêm mới sản phẩm có ID: $product->id";
        session()->flash('success', $this->productId ? 'Cập nhật sản phẩm thành công' : 'Thêm sản phẩm thành công');
        return redirect()->route('admin.product.index');
    }

    public function render()
    {
        return view('livewire.admin.product.product-editor', [
            'title' => $this->productId ? 'Chỉnh sửa sản phẩm' : 'Thêm sản phẩm mới'
        ])->extends('admin.app')
        ->section('content')
        ->layoutData(['title' => $this->productId ? 'Chỉnh sửa sản phẩm' : 'Thêm sản phẩm mới']);
    }
}
