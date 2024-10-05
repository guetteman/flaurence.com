<?php

use App\Domain\LaraGraph\Node;
use App\Domain\LaraGraph\State;
use App\Domain\LaraGraph\StateGraph;
use App\Domain\LaraGraph\StateGraphRunner;

covers(StateGraphRunner::class);

describe('StateGraphRunner', function () {
    it('should execute all nodes in the graph', function () {
        $testState = new class extends State
        {
            public int $nodesCount = 0;
        };

        $testNode = new class extends Node
        {
            public function execute($state): State
            {
                $state->nodesCount++;

                return $state;
            }
        };

        $graph = new StateGraph($testState::class);

        $graph
            ->addNode('Test Node 1', $testNode)
            ->addNode('Test Node 2', $testNode)
            ->addEdge(StateGraph::START, 'Test Node 1')
            ->addEdge('Test Node 1', 'Test Node 2')
            ->addEdge('Test Node 2', StateGraph::END);

        $compiledGraph = $graph->compile();

        $result = $compiledGraph->invoke([]);
        expect($result->nodesCount)->toBe(2);
    });
});
