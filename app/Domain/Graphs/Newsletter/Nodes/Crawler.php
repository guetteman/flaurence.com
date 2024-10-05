<?php

namespace App\Domain\Graphs\Newsletter\Nodes;

use App\Domain\FireCrawl\DataObjects\CrawlData;
use App\Domain\Graphs\Newsletter\NewsletterState;
use App\Domain\LaraGraph\Node;
use App\Domain\Tools\DocumentLoaders\FirecrawlLoader;

/**
 * @extends Node<NewsletterState>
 */
class Crawler extends Node
{
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
            $document = $this->loadUrl($url);
            if ($document !== null) {
                $allDocuments = array_merge($allDocuments, $document);
            }
        }

        return $allDocuments;
    }

    /**
     * @return array<array<string, string>>|null
     */
    protected function loadUrl(string $url): ?array
    {
        $loader = new FirecrawlLoader(
            url: $url,
            apiKey: config()->string('services.firecrawl.api_key'),
            baseUrl: config()->string('services.firecrawl.base_url'),
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
