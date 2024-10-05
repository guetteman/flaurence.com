<?php

namespace App\Domain\FireCrawl\DataObjects;

use Spatie\LaravelData\Data;

class CrawlResponseData extends Data
{
    public function __construct(
        public bool $success,
        public ?string $id,
        public ?string $url,
        public ?string $error,
    ) {}
}
