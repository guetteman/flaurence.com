<?php

namespace App\Domain\LaraChain;

use OpenAI\Laravel\Facades\OpenAI;

class OpenAILLM extends LLM
{
    public function __construct(
        protected string $model = 'gpt-4o-mini'
    ) {}

    public function generate($prompt): string
    {
        $result = OpenAI::chat()->create([
            'model' => $this->model,
            'messages' => $prompt,
        ]);

        return $result->choices[0]->message->content;
    }
}
