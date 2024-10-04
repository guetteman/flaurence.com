<?php

namespace App\Domain\LaraGraph\Nodes;

use App\Domain\LaraGraph\Node;

class StartNode extends Node
{
    public function execute($state)
    {
        return $state;
    }
}
