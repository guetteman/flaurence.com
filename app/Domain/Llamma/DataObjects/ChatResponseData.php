<?php

namespace App\Domain\Llamma\DataObjects;

use Spatie\LaravelData\Data;

class ChatResponseData extends Data
{
    public function __construct(
        public string $model,
        /** @var array<string, string> */
        public array $message,
        public bool $done,
        public string $done_reason,
    ) {}
}
