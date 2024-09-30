<?php

namespace App\Domain\Tools\FireCrawl\DataObjects;

use Spatie\LaravelData\Data;

class CancelCrawlResponseData extends Data
{
    public function __construct(
        public bool $success,
        public string $message,
    ) {}
}
