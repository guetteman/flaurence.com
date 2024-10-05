<?php

namespace App\Domain\FireCrawl\Requests;

use App\Domain\FireCrawl\DataObjects\CrawlOptionsData;
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
        protected readonly string $url,
        protected ?CrawlOptionsData $options = null,
    ) {
        $this->options = $this->options ?? new CrawlOptionsData;
    }

    public function resolveEndpoint(): string
    {
        return '/crawl';
    }

    public function createDtoFromResponse(Response $response): CrawlResponseData
    {
        return CrawlResponseData::from($response->json());
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return array_merge(
            [
                'url' => $this->url,
                'maxDepth' => $this->options->maxDepth,
                'ignoreSitemap' => $this->options->ignoreSitemap,
                'limit' => $this->options->limit,
                'allowBackwardLinks' => $this->options->allowBackwardLinks,
                'allowExternalLinks' => $this->options->allowExternalLinks,
            ],
            array_filter([
                'excludePaths' => $this->options->excludePaths,
                'includePaths' => $this->options->includePaths,
                'webhook' => $this->options->webhook,
            ]),
            [
                'scrapeOptions' => array_filter([
                    'formats' => $this->options->scraperFormats,
                    'onlyMainContent' => $this->options->scraperOnlyMainContent,
                    'waitFor' => $this->options->scraperWaitFor,
                    'includeTags' => $this->options->scraperIncludeTags,
                    'excludeTags' => $this->options->scraperExcludeTags,
                ]),
            ]
        );
    }
}
