<?php

use App\Domain\LaraGraph\Checkpointers\Checkpointer;
use App\Domain\LaraGraph\Exceptions\NodeIsNotReachableException;
use App\Domain\LaraGraph\Node;
use App\Domain\LaraGraph\State;
use App\Domain\LaraGraph\StateGraph;

covers(StateGraph::class);

describe('StateGraph', function () {
    it('should compile a graph', function () {
        $testState = new class extends State
        {
            public bool $updated = false;
        };

        $testNode = new class extends Node
        {
            public function execute($state): State
            {
                $state->updated = true;

                return $state;
            }
        };

        $graph = new StateGraph($testState::class);

        $graph
            ->addNode('Test Node', $testNode)
            ->addNode('Test Node 2', $testNode)
            ->addEdge(StateGraph::START, 'Test Node')
            ->addEdge(StateGraph::START, 'Test Node 2')
            ->addEdge('Test Node 2', StateGraph::END)
            ->addEdge('Test Node', StateGraph::END);

        $compiledGraph = $graph->compile();

        $result = $compiledGraph->invoke([]);
        expect($result)->toBeInstanceOf($testState::class)
            ->and($result->updated)->toBeTrue();
    });

    it('should throw an exception if a node is not reachable', function () {
        $testState = new class extends State {};

        $testNode = new class extends Node
        {
            public function execute($state): State
            {
                return $state;
            }
        };

        $graph = new StateGraph($testState::class);

        $graph
            ->addNode('Test Node', $testNode)
            ->addNode('Test Node 2', $testNode)
            ->addEdge(StateGraph::START, 'Test Node')
            ->addEdge('Test Node', StateGraph::END);

        $graph->compile()->invoke([]);
    })->throws(NodeIsNotReachableException::class);

    it('should throw an exception if the end point is not reachable', function () {
        $testState = new class extends State {};

        $testNode = new class extends Node
        {
            public function execute($state): State
            {
                return $state;
            }
        };

        $graph = new StateGraph($testState::class);

        $graph
            ->addNode('Test Node', $testNode)
            ->addEdge(StateGraph::START, 'Test Node');

        $graph->compile()->invoke([]);
    })->throws(NodeIsNotReachableException::class);

    it('should call the checkpointer after each node execution', function () {
        $testState = new class extends State
        {
            public bool $updated = false;

            public bool $checkpointed = false;
        };

        $testNode = new class extends Node
        {
            public function execute($state): State
            {
                $state->updated = true;

                return $state;
            }
        };

        $checkpointer = new class extends Checkpointer
        {
            public function save(string $nodeName, $state): void
            {
                $state->checkpointed = true;
            }
        };

        $graph = new StateGraph($testState::class);

        $graph
            ->addNode('Test Node', $testNode)
            ->addEdge(StateGraph::START, 'Test Node')
            ->addEdge('Test Node', StateGraph::END);

        $compiledGraph = $graph->compile($checkpointer);

        $result = $compiledGraph->invoke([
            'testNode' => $testNode,
        ]);

        expect($result->checkpointed)->toBeTrue();
    });

    it('should throw InvalidArgumentException if node is not found when setting entry point', function () {
        $testState = new class extends State {};

        $testNode = new class extends Node
        {
            public function execute($state): State
            {
                return $state;
            }
        };

        $graph = new StateGraph($testState::class);

        $graph
            ->addNode('Test Node', $testNode)
            ->setEntryPoint('Test Node 2')
            ->addEdge(StateGraph::START, 'Test Node')
            ->addEdge('Test Node', StateGraph::END);

        $graph->compile()->invoke([]);
    })->throws(InvalidArgumentException::class, 'Node with name Test Node 2 does not exist in the graph');

    it('should throw InvalidArgumentException if node is not found when setting end point', function () {
        $testState = new class extends State {};

        $testNode = new class extends Node
        {
            public function execute($state): State
            {
                return $state;
            }
        };

        $graph = new StateGraph($testState::class);

        $graph
            ->addNode('Test Node', $testNode)
            ->setEndPoint('Test Node 2')
            ->addEdge(StateGraph::START, 'Test Node')
            ->addEdge('Test Node', StateGraph::END);

        $graph->compile()->invoke([]);
    })->throws(InvalidArgumentException::class, 'Node with name Test Node 2 does not exist in the graph');

    it('should throw InvalidArgumentException if edge from node is not found when adding edge', function () {
        $testState = new class extends State {};

        $testNode = new class extends Node
        {
            public function execute($state): State
            {
                return $state;
            }
        };

        $graph = new StateGraph($testState::class);

        $graph
            ->addNode('Test Node', $testNode)
            ->addEdge(StateGraph::START, 'Test Node')
            ->addEdge('Test Node 2', StateGraph::END);

        $graph->compile()->invoke([]);
    })->throws(InvalidArgumentException::class, 'Node with name Test Node 2 does not exist in the graph');

    it('should throw InvalidArgumentException if edge to node is not found when adding edge', function () {
        $testState = new class extends State {};

        $testNode = new class extends Node
        {
            public function execute($state): State
            {
                return $state;
            }
        };

        $graph = new StateGraph($testState::class);

        $graph
            ->addNode('Test Node', $testNode)
            ->addEdge(StateGraph::START, 'Test Node 2')
            ->addEdge('Test Node', StateGraph::END);

        $graph->compile()->invoke([]);
    })->throws(InvalidArgumentException::class, 'Node with name Test Node 2 does not exist in the graph');
});
