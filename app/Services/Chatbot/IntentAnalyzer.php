<?php

namespace App\Services\Chatbot;

use voku\helper\ASCII;

class IntentAnalyzer
{
    private $rules;

    public function __construct(ChatbotConfig $config)
    {
        $this->rules = $config->getIntentRules();
    }

    public function analyze($message)
{
    $normalizedMessage = ASCII::to_ascii(mb_strtolower($message));

    foreach ($this->rules as $intent => $config) {
        if (!empty($config['keywords'])) {
            foreach ($config['keywords'] as $keyword) {
                $normalizedKeyword = ASCII::to_ascii(mb_strtolower($keyword));

                if (stripos($normalizedMessage, $normalizedKeyword) !== false) {
                    return $intent;
                }
            }
        }
    }

    return 'unknown';
}

}
