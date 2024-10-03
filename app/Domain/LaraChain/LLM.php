<?php

namespace App\Domain\LaraChain;

abstract class LLM
{
    abstract public function generate(array $prompt): string;
}
