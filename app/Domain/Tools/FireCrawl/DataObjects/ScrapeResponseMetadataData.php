<?php

namespace App\Domain\Tools\FireCrawl\DataObjects;

use Spatie\LaravelData\Data;

class ScrapeResponseMetadataData extends Data
{
    public function __construct(
        public string $title,
        public int $statusCode,
        public ?string $description,
        public ?string $language,
        public ?string $keywords,
        public ?string $robots,
        public ?string $ogTitle,
        public ?string $ogDescription,
        public ?string $ogUrl,
        public ?string $ogImage,
        public ?string $ogSiteName,
        public ?string $sourceURL,
    ) {}
}
