<?php

namespace App\Domain\Graphs\Newsletter\Nodes;

use App\Domain\FireCrawl\DataObjects\CrawlData;
use App\Domain\Graphs\Newsletter\NewsletterState;
use App\Domain\LaraGraph\Node;
use App\Domain\Tools\DocumentLoaders\FireCrawlLoader;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

/**
 * @extends Node<NewsletterState>
 */
class Crawler extends Node
{
    /**
     * @param  NewsletterState  $state
     *
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function execute($state): NewsletterState
    {
        $state->crawledPages = $this->loadUrls($state);

        return $state;
    }

    /**
     * @return array<array<string, string>>
     *
     * @throws FatalRequestException
     * @throws RequestException
     */
    protected function loadUrls(NewsletterState $state): array
    {
        $urls = $state->urls;
        $allDocuments = [];

        foreach ($urls as $url) {
            $document = $this->loadUrl($url, $state);
            if ($document !== null) {
                $allDocuments = array_merge($allDocuments, $document);
            }
        }

        return $allDocuments;
    }

    /**
     * @return array<array<string, string>>|null
     *
     * @throws FatalRequestException
     * @throws RequestException
     */
    protected function loadUrl(string $url, NewsletterState $state): ?array
    {
        $loader = new FireCrawlLoader(
            url: $url,
            apiKey: config()->string('services.firecrawl.api_key'),
            id: $state->graphId,
            baseUrl: config()->string('services.firecrawl.base_url'),
            limit: 1,
            excludePaths: $state->excludePaths,
        );
        $result = $loader->load();

        if ($result === null) {
            return null;
        }

        return collect($result->data)->map(function (CrawlData $data) {
            return [
                'url' => $data->metadata->sourceURL,
                'content' => $data->html,
            ];
        })->all();
    }
}
