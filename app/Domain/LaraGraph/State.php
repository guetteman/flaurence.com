<?php

namespace App\Domain\LaraGraph;

abstract class State
{
    public function get(string $key): mixed
    {
        return $this->$key;
    }
}
