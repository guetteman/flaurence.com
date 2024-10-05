<?php

namespace App\Domain\LaraChain;

abstract class LLM
{
    /**
     * @param  array<int, array<string, string>>  $prompt
     */
    abstract public function generate(array $prompt): string;
}
