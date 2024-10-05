<?php

namespace App\Domain\LaraGraph\Nodes;

use App\Domain\LaraGraph\Node;
use App\Domain\LaraGraph\State;

/**
 * @template TState of State
 *
 * @extends Node<TState>
 */
class StartNode extends Node
{
    /**
     * @param  TState  $state
     * @return TState
     */
    public function execute($state)
    {
        return $state;
    }
}
