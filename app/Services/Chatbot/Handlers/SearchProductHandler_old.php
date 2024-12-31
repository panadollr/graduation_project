<?php

namespace App\Services\Chatbot\Handlers;

use App\Models\Category;
use App\Models\Product;
use voku\helper\ASCII;

class SearchProductHandler_old
{
    public function handle($message)
    {
        $context = $this->parseMessageContext($message);

        $query = Product::query();

        // Lọc theo danh mục
        if (!empty($context['category'])) {
            $category = Category::where('slug', $context['category'])->first();

            if ($category) {
                $categoryIds = $category->getAllChildrenIds();
                $categoryIds[] = $category->id; // Thêm ID danh mục gốc
            } else {
                $categoryIds = [];
            }

            $query->whereHas('category', function ($q) use ($categoryIds) {
                $q->whereIn('id', $categoryIds);
            });
        }

        // Lọc theo thương hiệu
        if (!empty($context['brand'])) {
            $query->whereHas('brand', function ($q) use ($context) {
                $q->where('slug', $context['brand']);
            });
        }

        // Lọc theo giá
        if (!empty($context['price'])) {
            $query->where('base_price', $context['price']['operator'], $context['price']['value']);
        }

        // Lọc theo tính năng (RAM, v.v.)
        if (!empty($context['features'])) {
            foreach ($context['features'] as $feature => $value) {
                $query->where($feature, '=', $value);
            }
        }

        $products = $query->take(5)->get();

        if ($products->isEmpty()) {
            return 'Rất tiếc, tôi không tìm thấy sản phẩm nào phù hợp với yêu cầu của bạn. Bạn có thể thử thay đổi yêu cầu không?';
        }

        $response = "Dựa trên yêu cầu của bạn, tôi tìm thấy các sản phẩm sau:<ul>";
        foreach ($products as $product) {
            $response .= "<li><a href='{$product->url}' style='color: #0056b3; text-decoration: none; font-weight: bold;'>{$product->name}</a>: {$product->formatBasePriceWithCurrency()}</li>";
        }
        $response .= "</ul>";

        return $response;
    }

    private function parseMessageContext($message)
    {
        $categories = Category::where('type', '')->pluck('name', 'slug')->toArray();
        $brands = Category::where('type', 'manufacturer')->pluck('name', 'slug')->toArray();
        
        $rules = json_decode(file_get_contents('storage/chatbot-data/context_rules.json'), true);

        $context = [
            'category' => null,
            'brand' => null,
            'price' => null,
            'features' => [],
            'sentiment' => 'neutral',  // Mới thêm để lưu trữ cảm xúc
            'reaction' => '',          // Thêm phản ứng đối với cảm xúc tiêu cực
        ];

        foreach ($categories as $slug => $name) {
            if (preg_match("/\b" . preg_quote(mb_strtolower($name), '/') . "\b/u", mb_strtolower($message))) {
                $context['category'] = $slug;
                break;
            }
        }

        // Duyệt qua thương hiệu từ JSON
        foreach ($brands as $slug => $name) {
            if (str_contains(mb_strtolower($message), mb_strtolower($name))) {
                $context['brand'] = $slug;
                break;
            }
        }

        // Xử lý phân tích giá
        if (!empty($rules['intents']['search_product']['price_keywords'])) {
            // Chuẩn hóa chuỗi đầu vào (loại bỏ dấu)
            $normalizedMessage = ASCII::to_ascii($message);
        
            foreach ($rules['intents']['search_product']['price_keywords'] as $operator => $keywords) {
                foreach ($keywords as $keyword) {
                    // Chuẩn hóa từ khóa (loại bỏ dấu)
                    $normalizedKeyword = ASCII::to_ascii($keyword);
        
                    // Regex tìm giá trị với đơn vị: trieu, ngan, nghin, tram
                    if (preg_match("/\b{$normalizedKeyword}\s*(\d+(?:[\.,]\d{1,3})?)\s*(trieu|ngan|nghin|tram ngan|tram|k)?\b/ui", $normalizedMessage, $matches)) {
                        $rawValue = (float)preg_replace('/[^\d.]/', '', $matches[1]); // Chuyển đổi giá trị
        
                        // Chuyển đổi đơn vị thành đồng
                        $unit = mb_strtolower($matches[2] ?? '');
                        $value = match ($unit) {
                            'trieu' => $rawValue * 1_000_000,
                            'ngan', 'nghin' => $rawValue * 1_000,
                            'tram ngan' => $rawValue * 100_000,
                            'tram' => $rawValue * 100,
                            default => $rawValue, // Mặc định coi là đồng nếu không có đơn vị
                        };
        
                        // Lưu vào context
                        $context['price'] = ['operator' => $operator, 'value' => $value];
                        break 2; // Thoát vòng lặp khi đã tìm thấy giá
                    }
                }
            }
        }

        return $context;
    }
}
