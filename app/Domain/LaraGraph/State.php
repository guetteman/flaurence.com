<?php

namespace App\Domain\LaraGraph;

abstract class State
{
    public function __construct(public string $graphId = '') {}
}
