<?php
namespace App\Services\Chatbot\Handlers;

class FAQHandler
{
    public function handle($message)
    {
        $rules = json_decode(file_get_contents('storage/chatbot-data/context_rules.json'), true);
        foreach ($rules['intents']['faq']['questions'] as $keyword => $answer) {
            if (stripos($message, $keyword) !== false) {
                return $answer;
            }
        }
        return 'Xin lỗi, tôi không tìm thấy câu trả lời phù hợp.';
    }
}
