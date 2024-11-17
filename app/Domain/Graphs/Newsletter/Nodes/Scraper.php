<?php

namespace App\Domain\Graphs\Newsletter\Nodes;

use App\Domain\FireCrawl\DataObjects\ScrapeOptionsData;
use App\Domain\FireCrawl\DataObjects\ScrapeResponseData;
use App\Domain\FireCrawl\FireCrawlConnector;
use App\Domain\Graphs\Newsletter\NewsletterState;
use App\Domain\LaraGraph\Node;
use App\Domain\Tools\DocumentLoaders\Events\FireCrawlLoaderExecutedEvent;
use Throwable;

/**
 * @extends Node<NewsletterState>
 */
class Scraper extends Node
{
    /**
     * @param  NewsletterState  $state
     */
    public function execute($state): NewsletterState
    {
        $state->crawledPages = $this->loadUrls($state);

        return $state;
    }

    /**
     * @return array<array<string, string>>
     */
    protected function loadUrls(NewsletterState $state): array
    {
        $urls = $state->urls;
        $allDocuments = [];

        foreach ($urls as $url) {
            $document = $this->loadUrl($url, $state);
            if ($document !== null) {
                $allDocuments[] = $document;
            }
        }

        dump($allDocuments);

        return $allDocuments;
    }

    /**
     * @return array<string, string>|null
     */
    protected function loadUrl(string $url, NewsletterState $state): ?array
    {
        $firecrawl = new FireCrawlConnector(
            baseUrl: config()->string('services.firecrawl.base_url'),
            token: config()->string('services.firecrawl.api_key'),
        );

        try {
            /** @var ScrapeResponseData $result */
            $result = $firecrawl->scrape(url: $url, options: new ScrapeOptionsData(
                waitFor: 3000,
            ))->dto();

            FireCrawlLoaderExecutedEvent::dispatch($state->graphId, 1, 1);

            return [
                'url' => $url,
                'content' => $result->html,
            ];
        } catch (Throwable $e) {
            dump($e);
            return null;
        }
    }
}
