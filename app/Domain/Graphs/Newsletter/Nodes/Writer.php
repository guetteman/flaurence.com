<?php

namespace App\Domain\Graphs\Newsletter\Nodes;

use App\Domain\LaraGraph\Node;
use App\Domain\LaraGraph\State;

class Writer extends Node
{
    public function execute(State $state): State
    {
        return $state;
    }
}
