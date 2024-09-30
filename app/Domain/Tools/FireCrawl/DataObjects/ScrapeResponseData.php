<?php

namespace App\Domain\Tools\FireCrawl\DataObjects;

use Spatie\LaravelData\Data;

class ScrapeResponseData extends Data
{
    public function __construct(
        public string $markdown,
        public string $html,
        public ScrapeResponseMetadataData $metadata,
    ) {}
}
