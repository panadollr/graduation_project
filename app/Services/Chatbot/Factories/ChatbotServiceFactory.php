<?php

namespace App\Services\Chatbot\Factories;

use App\Services\Chatbot\Handlers\FAQHandler;
use App\Services\Chatbot\Handlers\GreetingHandler;
use App\Services\Chatbot\Handlers\SearchProductHandler;
use App\Services\Chatbot\Handlers\SentimentAnalysisHandler;

class ChatbotServiceFactory
{
    protected $handlers;

    public function __construct(array $handlers)
    {
        $this->handlers = $handlers;
    }

    // Phương thức tĩnh để tạo dịch vụ
    public static function createHandlers($config)
    {
        $handlerClasses = [
            'search_product' => SearchProductHandler::class,
            'greeting' => GreetingHandler::class,
            'faq' => FAQHandler::class,
            'negative_sentiment' => SentimentAnalysisHandler::class,
        ];

        $handlers = [];
        foreach ($handlerClasses as $key => $handlerClass) {
            $handlers[$key] = new $handlerClass($config);
        }

        return new self($handlers);
    }

    public function getHandler($intent)
    {
        return $this->handlers[$intent];
    }

    public function hasHandler($intent)
    {
        return isset($this->handlers[$intent]);
    }

    public static function getFallbackResponse($fallbackResponses)
    {
        static $shuffledResponses = [];
        static $currentIndex = 0;

        if (empty($shuffledResponses) || $currentIndex >= count($shuffledResponses)) {
            $shuffledResponses = $fallbackResponses;
            shuffle($shuffledResponses);
            $currentIndex = 0;
        }

        $response = $shuffledResponses[$currentIndex];
        $currentIndex++;

        return $response;
    }
}
