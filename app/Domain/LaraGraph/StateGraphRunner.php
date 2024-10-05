<?php

namespace App\Domain\LaraGraph;

/**
 * @template TState of State
 */
readonly class StateGraphRunner
{
    public function __construct(
        /** @var array<string, callable(TState): TState> */
        private array $nodeFunctions,
        /** @var array<string, callable(TState): string> */
        private array $transitions,
        private string $entryPoint,
        private string $endPoint,
        /** @var class-string<TState> */
        private string $initialState,
    ) {}

    /**
     * @param  array<string, mixed>  $input
     * @return TState
     */
    public function invoke(array $input)
    {
        $state = new $this->initialState($input);
        $currentNode = $this->entryPoint;

        while ($currentNode !== $this->endPoint) {
            $nodeFunction = $this->nodeFunctions[$currentNode];
            $state = $nodeFunction($state);

            $transitionFunction = $this->transitions[$currentNode];
            $nextNode = $transitionFunction($state);
            $currentNode = $nextNode;
        }

        return $state;
    }
}
