<?php

namespace App\Domain\LaraGraph\Checkpointers;

use App\Domain\LaraGraph\State;

/**
 * @template TState of State
 */
abstract class Checkpointer
{
    /**
     * @param  TState  $state
     */
    abstract public function save(string $nodeName, $state): void;
}
