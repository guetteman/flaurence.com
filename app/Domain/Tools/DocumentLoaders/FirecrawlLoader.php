<?php

namespace App\Domain\Tools\DocumentLoaders;

use App\Domain\FireCrawl\CrawlStatusEnum;
use App\Domain\FireCrawl\DataObjects\CrawlResponseData;
use App\Domain\FireCrawl\DataObjects\GetCrawlStatusResponseData;
use App\Domain\FireCrawl\FireCrawlConnector;
use App\Domain\FireCrawl\Requests\CrawlRequest;
use App\Domain\FireCrawl\Requests\GetCrawlStatusRequest;

/**
 * @extends DocumentLoader<GetCrawlStatusResponseData>
 */
class FirecrawlLoader extends DocumentLoader
{
    private FireCrawlConnector $firecrawl;

    public function __construct(
        private readonly string $url,
        private readonly string $apiKey,
    ) {}

    public function load(): GetCrawlStatusResponseData
    {
        $this->firecrawl = new FireCrawlConnector(
            baseUrl: 'https://api.firecrawl.dev',
            token: $this->apiKey,
        );
        $crawlRequest = new CrawlRequest($this->url);

        /** @var CrawlResponseData $crawlJob */
        $crawlJob = $this->firecrawl->send($crawlRequest)->dto();
        return $this->getCrawlResults($crawlJob->id);
    }

    protected function getCrawlResults(string $crawlJobId, $results = []): GetCrawlStatusResponseData
    {
        $getCrawlStatusRequest = new GetCrawlStatusRequest($crawlJobId);
        /** @var GetCrawlStatusResponseData $crawlStatus */
        $crawlStatus = $this->firecrawl->send($getCrawlStatusRequest)->dto();

        if ($crawlStatus->status === CrawlStatusEnum::Scraping) {
            sleep(3);
            return $this->getCrawlResults($crawlJobId, $results);
        }

        return $crawlStatus;
    }
}
