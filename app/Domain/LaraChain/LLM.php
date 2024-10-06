<?php

namespace App\Domain\LaraChain;

abstract class LLM
{
    abstract public static function provider(): string;

    /**
     * @param  array<int, array<string, string>>  $prompt
     */
    abstract public function generate(array $prompt): string;
}
