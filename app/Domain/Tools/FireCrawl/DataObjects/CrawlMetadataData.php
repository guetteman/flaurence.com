<?php

namespace App\Domain\Tools\FireCrawl\DataObjects;

use Spatie\LaravelData\Data;

class CrawlMetadataData extends Data
{
    public function __construct(
        public string $title,
        public string $description,
        public ?string $language,
        public string $sourceURL,
        public int $statusCode,
        public ?string $error
    ) {}
}
