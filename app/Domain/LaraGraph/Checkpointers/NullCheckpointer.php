<?php

namespace App\Domain\LaraGraph\Checkpointers;

use App\Domain\LaraGraph\State;

/**
 * @template TState of State
 * @extends Checkpointer<TState>
 */
class NullCheckpointer extends Checkpointer
{
    /**
     * @param  TState  $state
     */
    public function save(string $nodeName, $state): void
    {
        // No-op
    }
}
