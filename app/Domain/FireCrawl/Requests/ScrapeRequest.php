<?php

namespace App\Domain\FireCrawl\Requests;

use App\Domain\FireCrawl\DataObjects\ScrapeResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class ScrapeRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        public string $url,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/scrape';
    }

    public function createDtoFromResponse(Response $response): ScrapeResponseData
    {
        return ScrapeResponseData::from($response->json());
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return [
            'url' => $this->url,
            'formats' => ['markdown', 'html'],
        ];
    }
}
