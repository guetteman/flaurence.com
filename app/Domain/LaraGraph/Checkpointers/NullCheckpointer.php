<?php

namespace App\Domain\LaraGraph\Checkpointers;

class NullCheckpointer extends Checkpointer
{
    public function save(string $nodeName, $state): void
    {
        // TODO: Implement save() method.
    }
}
