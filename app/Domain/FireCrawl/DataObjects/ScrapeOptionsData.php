<?php

namespace App\Domain\FireCrawl\DataObjects;

use Spatie\LaravelData\Data;

class ScrapeOptionsData extends Data
{
    public function __construct(
        /** @var array<string> */
        public array $formats = ['markdown', 'html'],
        public bool $onlyMainContent = true,
        /** @var array<string> */
        public ?array $includeTags = [],
        /** @var array<string> */
        public ?array $excludeTags = [],
        public int $waitFor = 0,
    ) {}
}
