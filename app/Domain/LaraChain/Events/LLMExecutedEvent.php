<?php

namespace App\Domain\LaraChain\Events;

use Illuminate\Foundation\Events\Dispatchable;

class LLMExecutedEvent
{
    use Dispatchable;

    public function __construct(
        public string $id,
        public string $provider,
        public string $model,
        /** @var array<string, int> */
        public array $usage,
    ) {}
}
