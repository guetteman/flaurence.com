<?php

namespace App\Domain\LaraGraph;

abstract class Node
{
    abstract public function execute(): void;
}
