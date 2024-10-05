<?php

namespace App\Domain\Tools\DocumentLoaders;

use App\Domain\FireCrawl\DataObjects\CrawlOptionsData;
use App\Domain\FireCrawl\DataObjects\CrawlResponseData;
use App\Domain\FireCrawl\DataObjects\GetCrawlStatusResponseData;
use App\Domain\FireCrawl\Enums\CrawlStatusEnum;
use App\Domain\FireCrawl\FireCrawlConnector;
use Illuminate\Support\Sleep;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

/**
 * @extends DocumentLoader<GetCrawlStatusResponseData>
 */
class FirecrawlLoader extends DocumentLoader
{
    private FireCrawlConnector $firecrawl;

    public function __construct(
        private readonly string $url,
        private readonly string $apiKey,
        private readonly string $baseUrl = 'https://api.firecrawl.dev/v1',
        private readonly int $limit = 3,
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
            options: new CrawlOptionsData(limit: $this->limit)
        )->dto();

        if ($crawlJob->error) {
            return null;
        }

        return $this->getCrawlResults($crawlJob->id);
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
