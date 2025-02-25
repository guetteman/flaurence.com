<?php

namespace App\Domain\FireCrawl\DataObjects;

use App\Domain\FireCrawl\Enums\CrawlStatusEnum;
use Spatie\LaravelData\Data;

class GetCrawlStatusResponseData extends Data
{
    public function __construct(
        public CrawlStatusEnum $status,
        public int $total,
        public int $completed,
        public int $creditsUsed,
        public string $expiresAt,
        public ?string $next = null,
        /** @var array<int, CrawlData> */
        public array $data = [],
    ) {}
}
