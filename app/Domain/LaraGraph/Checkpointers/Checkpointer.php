<?php

namespace App\Domain\LaraGraph\Checkpointers;

abstract class Checkpointer
{
    abstract public function save(string $nodeName, $state): void;
}
