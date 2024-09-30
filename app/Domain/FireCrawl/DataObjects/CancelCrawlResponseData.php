<?php

namespace App\Domain\FireCrawl\DataObjects;

use Spatie\LaravelData\Data;

class CancelCrawlResponseData extends Data
{
    public function __construct(
        public bool $success,
        public string $message,
    ) {}
}
