<?php

namespace App\Domain\FireCrawl\Requests;

use App\Domain\FireCrawl\DataObjects\ExtractResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class ExtractRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        public string $url,
        public string $prompt,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/scrape';
    }

    public function createDtoFromResponse(Response $response): ExtractResponseData
    {
        return ExtractResponseData::from($response->json());
    }

    protected function defaultBody(): array
    {
        return [
            'url' => $this->url,
            'formats' => ['extract'],
            'extract' => [
                'prompt' => $this->prompt,
            ],
        ];
    }
}
