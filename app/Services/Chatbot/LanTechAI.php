<?php

namespace App\Services\Chatbot;

use App\Services\Chatbot\Contracts\BaseChatbotService;
use App\Services\Chatbot\Factories\ChatbotServiceFactory;
use voku\helper\ASCII;

class LanTechAI extends BaseChatbotService
{
    public static function ask($message, $userId)
    {
        $config = new ChatbotConfig();
        $intentAnalyzer = new IntentAnalyzer($config); 
        $serviceFactory = ChatbotServiceFactory::createHandlers($config);
 
        // Phân tích intent
        $intent = $intentAnalyzer->analyze($message);

        if (!$intent || !$serviceFactory->hasHandler($intent)) {
            return self::getFallbackResponse($serviceFactory, $config);
        }
         
        // Kiểm tra nếu không xác định được intent
        $handler = $serviceFactory->getHandler($intent);
        $normalizedMessage = self::normalizeMessage($message);
        $normalizedKeywords = self::normalizeKeywords(
            $config->getIntentRules()[$intent]['keywords'] ?? []
        );

        return $handler->handle($normalizedMessage, $normalizedKeywords);
    }

    private static function getFallbackResponse($serviceFactory, $config)
    {
        return $serviceFactory->getFallbackResponse($config->getFallbackResponses());
    }

    private static function normalizeMessage($message)
    {
        return ASCII::to_ascii(mb_strtolower($message));
    }

    private static function normalizeKeywords($keywords)
    {
        return array_map(fn($keyword) => ASCII::to_ascii(mb_strtolower($keyword)), $keywords);
    }

}
