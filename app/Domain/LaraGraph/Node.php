<?php

namespace App\Domain\LaraGraph;

/**
 * @template T of State
 */
abstract class Node
{
    /**
     * @param  T  $state
     * @return T
     */
    abstract public function execute($state);
}
