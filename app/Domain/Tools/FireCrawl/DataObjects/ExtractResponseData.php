<?php

namespace App\Domain\Tools\FireCrawl\DataObjects;

use Spatie\LaravelData\Data;

class ExtractResponseData extends Data
{
    public function __construct(
        public array $extract,
        public ScrapeResponseMetadataData $metadata,
    ) {}
}
