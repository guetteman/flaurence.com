<?php

namespace App\Domain\Llamma;

use App\Domain\Llamma\Requests\ChatRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Connector;
use Saloon\Http\Response;

class OLlamaConnector extends Connector
{
    public function __construct(
        public readonly string $baseUrl = 'http://127.0.0.1:11434',
        public readonly string $model = 'llama3.2',
    ) {}

    /**
     * @param  array<array<string, string>>  $messages
     * @param  array<string>|null  $functions
     *
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function chat(array $messages, ?array $functions = null, bool $stream = false): Response
    {
        return $this->send(new ChatRequest(
            model: $this->model,
            messages: $messages,
            functions: $functions,
            stream: $stream,
        ));
    }

    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
