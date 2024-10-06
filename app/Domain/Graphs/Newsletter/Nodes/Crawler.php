<?php

namespace App\Domain\Graphs\Newsletter\Nodes;

use App\Domain\FireCrawl\DataObjects\CrawlData;
use App\Domain\Graphs\Newsletter\NewsletterState;
use App\Domain\LaraGraph\Node;
use App\Domain\Tools\DocumentLoaders\FirecrawlLoader;
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
            $document = $this->loadUrl($url, $state->excludePaths);
            if ($document !== null) {
                $allDocuments = array_merge($allDocuments, $document);
            }
        }

        return $allDocuments;
    }

    /**
     * @param  array<string>  $excludePaths
     * @return array<array<string, string>>|null
     *
     * @throws FatalRequestException
     * @throws RequestException
     */
    protected function loadUrl(string $url, array $excludePaths = []): ?array
    {
        $loader = new FirecrawlLoader(
            url: $url,
            apiKey: config()->string('services.firecrawl.api_key'),
            baseUrl: config()->string('services.firecrawl.base_url'),
            excludePaths: $excludePaths,
        );
        $result = $loader->load();

        if ($result === null) {
            return null;
        }

        return collect($result->data)->map(function (CrawlData $data) {
            return [
                'url' => $data->metadata->sourceURL,
                'content' => $data->markdown,
            ];
        })->all();
    }
}
