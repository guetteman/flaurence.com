<?php

namespace App\Domain\FireCrawl\Requests;

use App\Domain\FireCrawl\DataObjects\GetCrawlStatusResponseData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetCrawlStatusRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/crawl/'.$this->id;
    }

    public function createDtoFromResponse(Response $response): GetCrawlStatusResponseData
    {
        return GetCrawlStatusResponseData::from($response->json());
    }
}
