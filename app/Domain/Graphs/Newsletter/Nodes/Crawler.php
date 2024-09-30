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

    protected function loadUrls(NewsletterState $state): array
    {
        $urls = $state->urls;
        $allDocuments = [];

        foreach ($urls as $url) {
            $document = $this->loadUrl($url);
            $allDocuments = array_merge($allDocuments, $document);
        }
        return $allDocuments;
    }

    protected function loadUrl(string $url): array
    {
        $loader = new FirecrawlLoader($url, config()->string('services.firecrawl.api_key'));
        $result = $loader->load();

        return collect($result->data)->map(function (CrawlData $data) {
            return [
                'url' => $data->metadata->sourceURL,
                'content' => $data->markdown,
            ];
        })->all();
    }
}
