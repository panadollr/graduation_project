<?php

namespace App\Services\Chatbot\Handlers;

use App\Models\Category;
use App\Models\Product;
use App\Services\HttpService;
use voku\helper\ASCII;

class SearchProductHandler
{
    public function handle($message)
    {
        $context = $this->parseMessageContext($message);
        $products = $this->getFilteredProducts($context);

        return $this->generateProductResponse($products);
    }

    private function parseMessageContext($message)
    {
        $rules = json_decode(file_get_contents('storage/chatbot-data/context_rules.json'), true);

        $categories = Category::where('type', '')->pluck('slug')->toArray();
        $brands = Category::where('type', 'manufacturer')->pluck('slug')->toArray();

        $context = [
            'category' => $this->findMatch($message, $categories),
            'brand' => $this->findMatch($message, $brands),
            'price' => $this->extractPrice($message, $rules),
            'quantity' => $this->extractQuantity($message, $rules),
            'features' => [], // Tính năng có thể mở rộng sau
        ];

        return $context;
    }

    private function findMatch($message, $items)
    {
        foreach ($items as $slug) {
            if (str_contains(mb_strtolower($message), mb_strtolower($slug))) {
                return $slug;
            }
        }
        return null;
    }

    private function extractPrice($message, $rules)
    {
        foreach ($rules['intents']['search_product']['price_keywords'] as $operator => $keywords) {
            foreach ($keywords as $keyword) {
                $pattern = "/\b" . preg_quote(ASCII::to_ascii($keyword), '/') . "\s*(\d+(?:[\.,]\d{1,3})?)\s*(trieu|ngan|nghin|tram ngan|tram|k)?\b/ui";
                if (preg_match($pattern, $message, $matches)) {
                    $rawValue = (float)preg_replace('/[^\d.]/', '', $matches[1]);
                    $unit = mb_strtolower($matches[2] ?? '');
                    $value = match ($unit) {
                        'trieu' => $rawValue * 1_000_000,
                        'ngan', 'nghin' => $rawValue * 1_000,
                        'tram ngan' => $rawValue * 100_000,
                        'tram' => $rawValue * 100,
                        default => $rawValue,
                    };
                    return ['operator' => $operator, 'value' => $value];
                }
            }
        }
        return null;
    }

    private function extractQuantity($message, $rules)
    {
        foreach ($rules['intents']['search_product']['quantity_keywords'] as $keyword) {
            if (preg_match("/\b" . preg_quote($keyword, '/') . "\b/ui", $message, $matches)) {
                preg_match("/\d+/", $keyword, $quantity);
                if ($quantity) {
                    return (int)$quantity[0];
                }
            }
        }

        return null;
    }

    private function getFilteredProducts($context)
    {
        $query = Product::query();

        // Tìm sản phẩm theo thể loại nếu có
        if ($context['category']) {
            $categoryIds = $this->getCategoryIds($context['category']);
            $query->whereHas('category', fn($q) => $q->whereIn('id', $categoryIds));
        }

        // Tìm sản phẩm theo thương hiệu nếu có
        if ($context['brand']) {
            $query->whereHas('brand', fn($q) => $q->where('slug', 'like', "%{$context['brand']}%"));
        }

        // Xử lý giá nếu có yêu cầu
        if ($context['price']) {
            $query->where('base_price', $context['price']['operator'], $context['price']['value']);
        }

        // Nếu yêu cầu là "giá thấp nhất", tìm sản phẩm có giá thấp nhất
        if ($context['price'] && $context['price']['operator'] === '=') {
            $query->orderBy('base_price', 'asc')->take(1); // Lấy sản phẩm có giá thấp nhất
        }

        // Xử lý số lượng sản phẩm yêu cầu
        if ($context['quantity']) {
            return $query->take((int)$context['quantity'])->get();
        }

        // Mặc định lấy 5 sản phẩm
        return $query->take(5)->get();
    }

    private function getCategoryIds($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->first();
        if ($category) {
            return array_merge($category->getAllChildrenIds()->toArray(), [$category->id]);
        }
        return [];
    }

    private function generateProductResponse($products)
    {
        if ($products->isEmpty()) {
            return 'Rất tiếc, tôi không tìm thấy sản phẩm nào phù hợp với yêu cầu của bạn. Bạn có thể thử thay đổi yêu cầu không?';
        }

        $response = "Dựa trên yêu cầu của bạn, tôi tìm thấy các sản phẩm sau:<ul style='list-style: none; padding: 0;'>";
        
        // Hiển thị sản phẩm giá thấp nhất đặc biệt
        if ($products->count() === 1) {
            $response .= "<li style='margin-bottom: 15px; color: green;'>";
            $response .= "<strong>Sản phẩm có giá thấp nhất:</strong>";
        } else {
            foreach ($products as $product) {
                $response .= "<li style='margin-bottom: 15px;'>";
                $response .= "<div style='display: flex; align-items: center;'>";
                $response .= "<img src='{$product->image}' alt='{$product->name}' style='width: 50px; height: 50px; object-fit: cover; border-radius: 8px; margin-right: 10px;'>";
                $response .= "<div>";
                $response .= "<a href='{$product->url()}' style='color: #0056b3; text-decoration: none; font-weight: bold;'>{$product->name}</a>";
                $response .= "<div style='color: #333;'>{$product->formatBasePriceWithCurrency()}</div>";
                $response .= "</div>";
                $response .= "</div>";
                $response .= "</li>";
            }
        }

        $response .= "</ul>";

        return $response;
    }

}
