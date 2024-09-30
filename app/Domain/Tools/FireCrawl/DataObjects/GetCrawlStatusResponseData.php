<?php

namespace App\Domain\Tools\FireCrawl\DataObjects;

use App\Domain\Tools\FireCrawl\CrawlStatusEnum;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

class GetCrawlStatusResponseData extends Data
{
    public function __construct(
        public CrawlStatusEnum $status,
        public int $total,
        public int $completed,
        public int $creditsUsed,
        public CarbonImmutable $expiresAt,
        public ?string $next = null,
        /** @var array<int, CrawlData> */
        public array $data = [],
    ) {}
}
