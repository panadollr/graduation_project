<?php
namespace App\Services\Chatbot\Handlers;

class SentimentAnalysisHandler
{
    public function handle($message)
    {
        $rules = json_decode(file_get_contents('storage/chatbot-data/context_rules.json'), true);
        foreach ($rules['intents']['negative_sentiment']['keywords'] as $keyword) {
            if (stripos($message, $keyword) !== false) {
                $response = $rules['intents']['negative_sentiment']['response'];
                return $response[array_rand($response)];
            }
        }
        return 'Xin lỗi, tôi không thể hỗ trợ bạn với nội dung này.';
    }
}
