<?php

namespace App\Services\Chatbot;

class ChatbotConfig
{
    private $rules;

    public function __construct()
    {
        $this->rules = json_decode(file_get_contents('storage/chatbot-data/context_rules.json'), true);
    }

    public function getIntentRules()
    {
        return $this->rules['intents'] ?? [];
    }

    public function getFallbackResponses(){
        return $this->rules['fallback_responses'] ?? [];
    }

}