<?php

namespace App\Domain\Llamma\Requests;

use App\Domain\Llamma\DataObjects\ChatResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class ChatRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $model = 'llama3.2',
        /** @var array<array<string, string>> */
        protected readonly array $messages = [],
        /** @var array<mixed>|null */
        protected readonly ?array $functions = null,
        protected readonly bool $stream = false,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/api/chat';
    }

    public function createDtoFromResponse(Response $response): ChatResponseData
    {
        return ChatResponseData::from($response->json());
    }

    /**
     * @return array<string, mixed>
     */
    public function defaultBody(): array
    {
        return array_merge(
            [
                'model' => $this->model,
                'messages' => $this->messages,
                'stream' => $this->stream,
            ],
            array_filter([
                'functions' => $this->functions,
            ])
        );
    }
}
