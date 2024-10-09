<?php

namespace App\Domain\LaraChain;

use App\Domain\LaraChain\Events\LLMExecutedEvent;
use App\Domain\Llamma\DataObjects\ChatResponseData;
use App\Domain\Llamma\OLlamaConnector;
use OpenAI\Laravel\Facades\OpenAI;

class OLlamaLLM extends LLM
{
    public function __construct(
        protected string $id = '',
        protected string $model = 'llama3.2',
    ) {}

    public function generate($prompt): string
    {
        $ollama = new OLlamaConnector(model: $this->model);

        /** @var ChatResponseData $response */
        $response = $ollama->chat(messages: $prompt)->dto();

        return data_get($response->message, 'content', '');
    }

    public static function provider(): string
    {
        return 'ollama';
    }
}
