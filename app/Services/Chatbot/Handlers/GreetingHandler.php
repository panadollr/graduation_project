<?php

namespace App\Services\Chatbot\Handlers;

class GreetingHandler
{
    private $rules;

    public function __construct($config)
    {
        $this->rules = $config->getIntentRules()['greeting']['keywords'] ?? [];
    }

    public function handle($normalizedMessage, $normalizedKeywords)
    {
        $response = 'Xin lỗi, tôi không tìm thấy câu trả lời phù hợp.';

        foreach ($normalizedKeywords as $normalizedKeyword) {
            if (stripos($normalizedMessage, $normalizedKeyword) !== false) {
                return "Chào bạn, tôi có thể giúp gì cho bạn nhỉ? Bạn có thể hỏi về sản phẩm, chính sách bảo hành hoặc dịch vụ đổi trả.";
            }
        }
        
        return $response;
    }
}
