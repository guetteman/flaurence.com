<?php

namespace App\Domain\FireCrawl\DataObjects;

use Spatie\LaravelData\Data;

class CrawlOptionsData extends Data
{
    public function __construct(
        /** @var array<string> */
        public ?array $excludePaths = null,
        /** @var array<string> */
        public ?array $includePaths = null,
        public int $maxDepth = 2,
        public bool $ignoreSitemap = true,
        public int $limit = 10,
        public bool $allowBackwardLinks = false,
        public bool $allowExternalLinks = false,
        public ?string $webhook = null,
        /** @var array<string> */
        public array $scraperFormats = ['markdown'],
        /** @var array<string> */
        public ?array $scraperIncludeTags = null,
        /** @var array<string> */
        public ?array $scraperExcludeTags = null,
        public bool $scraperOnlyMainContent = true,
        public int $scraperWaitFor = 123,
    ) {}
}
