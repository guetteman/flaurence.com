<?php

namespace App\Domain\Tools\DocumentLoaders\Events;

use Illuminate\Foundation\Events\Dispatchable;

class FireCrawlLoaderExecutedEvent
{
    use Dispatchable;

    public function __construct(
        public string $id,
        public int $totalPagesLoaded,
        public int $creditsUsed,
    ) {}
}
