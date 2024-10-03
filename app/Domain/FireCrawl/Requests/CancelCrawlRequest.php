<?php

namespace App\Domain\FireCrawl\Requests;

use App\Domain\FireCrawl\DataObjects\CancelCrawlResponseData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class CancelCrawlRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        public string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/crawls/'.$this->id;
    }

    public function createDtoFromResponse(Response $response): CancelCrawlResponseData
    {
        $data = $response->json();

        return CancelCrawlResponseData::from(data_get($data, 'data'));
    }
}
