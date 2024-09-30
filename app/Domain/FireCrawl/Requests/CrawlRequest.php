<?php

namespace App\Domain\FireCrawl\Requests;

use App\Domain\FireCrawl\DataObjects\CrawlResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CrawlRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        public string $url,
        public array $excludePaths = [],
        public array $includePaths = [],
        public int $maxDepth = 2,
        public bool $ignoreSitemap = true,
        public int $limit = 10,
        public bool $allowBackwardLinks = false,
        public bool $allowExternalLinks = false,
        public ?string $webhook = null,
        public array $scraperFormats = ['markdown'],
        public array $scraperHeaders = [],
        public array $scraperIncludeTags = [],
        public array $scraperExcludeTags = [],
        public bool $scraperOnlyMainContent = true,
        public int $scraperWaitFor = 123,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/crawl';
    }

    public function createDtoFromResponse(Response $response): CrawlResponseData
    {
        $data = $response->json();

        return CrawlResponseData::from(data_get($data, 'data'));
    }

    protected function defaultBody(): array
    {
        return [
            'url' => $this->url,
            'excludePaths' => $this->excludePaths,
            'includePaths' => $this->includePaths,
            'maxDepth' => $this->maxDepth,
            'ignoreSitemap' => $this->ignoreSitemap,
            'limit' => $this->limit,
            'allowBackwardLinks' => $this->allowBackwardLinks,
            'allowExternalLinks' => $this->allowExternalLinks,
            'webhook' => $this->webhook,
            'scraperOptions' => [
                'formats' => $this->scraperFormats,
                'headers' => $this->scraperHeaders,
                'includeTags' => $this->scraperIncludeTags,
                'excludeTags' => $this->scraperExcludeTags,
                'onlyMainContent' => $this->scraperOnlyMainContent,
                'waitFor' => $this->scraperWaitFor,
            ],
        ];
    }
}
