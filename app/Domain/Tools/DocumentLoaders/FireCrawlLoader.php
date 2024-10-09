<?php

namespace App\Domain\Tools\DocumentLoaders;

use App\Domain\FireCrawl\DataObjects\CrawlOptionsData;
use App\Domain\FireCrawl\DataObjects\CrawlResponseData;
use App\Domain\FireCrawl\DataObjects\GetCrawlStatusResponseData;
use App\Domain\FireCrawl\Enums\CrawlStatusEnum;
use App\Domain\FireCrawl\FireCrawlConnector;
use App\Domain\Tools\DocumentLoaders\Events\FireCrawlLoaderExecutedEvent;
use Illuminate\Support\Sleep;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

/**
 * @extends DocumentLoader<GetCrawlStatusResponseData>
 */
class FireCrawlLoader extends DocumentLoader
{
    private FireCrawlConnector $firecrawl;

    public function __construct(
        private readonly string $url,
        private readonly string $apiKey,
        private readonly string $id = '', // @pest-mutate-ignore
        private readonly string $baseUrl = 'https://api.firecrawl.dev/v1',
        private readonly int $limit = 3,
        /** @var array<string>|null */
        private readonly ?array $excludePaths = null,
    ) {}

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function load(): ?GetCrawlStatusResponseData
    {
        $this->firecrawl = new FireCrawlConnector(
            baseUrl: $this->baseUrl,
            token: $this->apiKey,
        );

        /** @var CrawlResponseData $crawlJob */
        $crawlJob = $this->firecrawl->crawl(
            url: $this->url,
            options: new CrawlOptionsData(excludePaths: $this->excludePaths, limit: $this->limit)
        )->dto();

        if ($crawlJob->error) {
            return null;
        }

        $response = $this->getCrawlResults($crawlJob->id);

        FireCrawlLoaderExecutedEvent::dispatch(
            $this->id,
            $response->total,
            $response->creditsUsed,
        );

        return $response;
    }

    protected function getCrawlResults(string $crawlJobId): GetCrawlStatusResponseData
    {
        /** @var GetCrawlStatusResponseData $crawlStatus */
        $crawlStatus = $this->firecrawl->getCrawlStatus($crawlJobId)->dto();

        if ($crawlStatus->status === CrawlStatusEnum::Scraping) {
            Sleep::for(3)->seconds();

            return $this->getCrawlResults($crawlJobId);
        }

        return $crawlStatus;
    }
}
