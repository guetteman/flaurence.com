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
        public ?array $excludePaths = null,
        public ?array $includePaths = null,
        public int $maxDepth = 2,
        public bool $ignoreSitemap = true,
        public int $limit = 10,
        public bool $allowBackwardLinks = false,
        public bool $allowExternalLinks = false,
        public ?string $webhook = null,
        public array $scraperFormats = ['markdown'],
        public ?array $scraperIncludeTags = null,
        public ?array $scraperExcludeTags = null,
        public bool $scraperOnlyMainContent = true,
        public int $scraperWaitFor = 123,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/crawl';
    }

    public function createDtoFromResponse(Response $response): CrawlResponseData
    {
        return CrawlResponseData::from($response->json());
    }

    protected function defaultBody(): array
    {
        return array_merge(
            [
                'url' => $this->url,
                'maxDepth' => $this->maxDepth,
                'ignoreSitemap' => $this->ignoreSitemap,
                'limit' => $this->limit,
                'allowBackwardLinks' => $this->allowBackwardLinks,
                'allowExternalLinks' => $this->allowExternalLinks,
            ],
            array_filter([
                'excludePaths' => $this->excludePaths,
                'includePaths' => $this->includePaths,
                'webhook' => $this->webhook,
            ]),
            [
                'scrapeOptions' => array_filter([
                    'formats' => $this->scraperFormats,
                    'onlyMainContent' => $this->scraperOnlyMainContent,
                    'waitFor' => $this->scraperWaitFor,
                    'includeTags' => $this->scraperIncludeTags,
                    'excludeTags' => $this->scraperExcludeTags,
                ]),
            ]
        );
    }
}
