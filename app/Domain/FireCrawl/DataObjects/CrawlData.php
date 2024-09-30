<?php

namespace App\Domain\FireCrawl\DataObjects;

use Spatie\LaravelData\Data;

class CrawlData extends Data
{
    public function __construct(
        public string $markdown,
        public ?string $html,
        public ?string $rawHtml,
        /** @var array<int, string> */
        public array $links,
        public ?string $screenshot,
        public CrawlMetadataData $metadata,
    ) {}
}
