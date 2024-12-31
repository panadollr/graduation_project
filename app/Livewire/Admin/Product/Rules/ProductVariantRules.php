<?php

namespace App\Livewire\Admin\Product\Rules;

class ProductVariantRules
{
    public static function rules($variants)
    {
        $rules = [
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.quantity' => 'required|integer|min:1',
        ];

        // Xác định các variants có thuộc tính màu sắc
        $colorVariants = collect($variants)->filter(function ($variant) {
            return collect($variant['options'])->filter(function ($value, $key) {
                // Kiểm tra xem có thuộc tính nào đó mà tên có thể đại diện cho màu sắc hay không
                return in_array(strtolower($key), ['màu sắc', 'color']); // Có thể thêm các tên khác nếu cần
            })->isNotEmpty();
        });

        // Lấy danh sách màu sắc khác nhau
        $uniqueColors = $colorVariants->pluck('options')->map(function ($options) {
            return $options['Màu sắc'] ?? $options['color'] ?? null; // Lấy giá trị màu sắc
        })->unique()->filter(); // Lọc ra các màu sắc khác nhau

         // Chỉ yêu cầu ảnh cho các variant với màu sắc khác nhau
         foreach ($uniqueColors as $index => $color) {
            // Tìm index của variant có màu sắc tương ứng
            $variantIndex = $colorVariants->search(function ($variant) use ($color) {
                return isset($variant['options']['Màu sắc']) && $variant['options']['Màu sắc'] === $color;
            });
            if ($variantIndex !== false) {
                $rules["variants.{$variantIndex}.image"] = 'required|image|max:2048';
            }
        }

        return $rules;
    }

    public static function messages()
    {
        return [
            'variants.*.price.required' => 'Bạn phải nhập giá cho phiên bản.',
            'variants.*.price.numeric' => 'Giá phải là một số hợp lệ.',
            'variants.*.price.min' => 'Giá phải lớn hơn hoặc bằng 0.',

            'variants.*.quantity.required' => 'Bạn phải nhập số lượng cho phiên bản.',
            'variants.*.quantity.integer' => 'Số lượng phải là một số nguyên.',
            'variants.*.quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',

            'variants.*.image.required' => 'Bạn phải chọn ảnh cho phiên bản.',
            'variants.*.image.image' => 'Ảnh phải có định dạng hợp lệ (jpg, png, ...).',
            'variants.*.image.max' => 'Dung lượng ảnh không được vượt quá 2MB.',
        ];
    }
}
