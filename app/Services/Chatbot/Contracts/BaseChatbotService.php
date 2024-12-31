<?php

namespace App\Services\Chatbot\Contracts;

use App\Services\Chatbot\ChatbotConfig;
use App\Services\Chatbot\Factories\ChatbotServiceFactory;
use App\Services\Chatbot\IntentAnalyzer;

abstract class BaseChatbotService
{
    protected $config;
    protected $intentAnalyzer;
    protected $serviceFactory;

    public function __construct(
        ChatbotConfig $config,
        IntentAnalyzer $intentAnalyzer,
        ChatbotServiceFactory $serviceFactory
    ) {
        $this->config = $config;
        $this->intentAnalyzer = $intentAnalyzer;
        $this->serviceFactory = $serviceFactory;
    }

    abstract public static function ask($message, $userId);
}
