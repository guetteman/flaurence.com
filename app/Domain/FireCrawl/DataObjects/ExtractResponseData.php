<?php

namespace App\Domain\FireCrawl\DataObjects;

use Spatie\LaravelData\Data;

class ExtractResponseData extends Data
{
    public function __construct(
        public array $extract,
        public ScrapeResponseMetadataData $metadata,
    ) {}
}
