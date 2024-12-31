<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ChatbotInteraction;
use App\Services\Chatbot\ChatbotConfig;
use App\Services\Chatbot\Factories\ChatbotServiceFactory;
use App\Services\Chatbot\IntentAnalyzer;
use voku\helper\ASCII;

class ChatbotController extends Controller
{
    public static function handleMessage($message, $userId)
    {
         // Tạo đối tượng ChatbotConfig
         $config = new ChatbotConfig();
         $intentAnalyzer = new IntentAnalyzer($config); 
 
         // Tạo đối tượng ChatbotServiceFactory
         $serviceFactory = ChatbotServiceFactory::createHandlers($config);
 
         // Phân tích intent và lấy dịch vụ tương ứng
         $intent = $intentAnalyzer->analyze($message);
         
         // Kiểm tra nếu không xác định được intent
        if (!$intent || !$serviceFactory->hasHandler($intent)) {
            $response = $serviceFactory->getFallbackResponse($message);
        } else {
            $handler = $serviceFactory->getHandler($intent);
            $normalizedMessage = ASCII::to_ascii(mb_strtolower($message));

            // Chuẩn hóa tất cả các từ khóa trong intent
            $normalizedKeywords = array_map(
                fn($keyword) => ASCII::to_ascii(mb_strtolower($keyword)),
                $config->getIntentRules()[$intent]['keywords'] ?? []
            );
            $response = $handler->handle($normalizedMessage, $normalizedKeywords);
        }

         self::logInteraction($message, $response, $userId);

        return $response;
    }

    private static function logInteraction($message, $response, $userId)
    {
        ChatbotInteraction::create([
            'user_id' => $userId,
            'message' => $message,
            'response' => $response,
        ]);
    }
}
