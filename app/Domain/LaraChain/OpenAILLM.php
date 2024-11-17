<?php

namespace App\Domain\LaraChain;

use App\Domain\LaraChain\Events\LLMExecutedEvent;
use OpenAI\Laravel\Facades\OpenAI;

class OpenAILLM extends LLM
{
    public function __construct(
        protected string $id = '',
        protected string $model = 'gpt-4o-mini',
    ) {}

    public function generate($prompt): string
    {
        $response = OpenAI::chat()->create([
            'model' => $this->model,
            'messages' => $prompt,
        ]);

        /** @var array<string, int> $usage */
        $usage = $response->usage->toArray();

        LLMExecutedEvent::dispatch(
            $this->id,
            static::provider(),
            $this->model,
            $usage,
        );

        return $response->choices[0]->message->content;
    }

    public static function provider(): string
    {
        return 'openai';
    }
}
