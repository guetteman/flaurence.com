<?php

namespace App\Domain\LaraGraph;

use App\Domain\LaraGraph\Checkpointers\Checkpointer;
use App\Domain\LaraGraph\Checkpointers\NullCheckpointer;
use App\Domain\LaraGraph\Exceptions\NodeIsNotReachableException;
use InvalidArgumentException;

class StateGraph
{
    const START = 'START';

    const END = 'END';

    /**
     * @var array<string, Node>
     */
    private array $nodes = [];

    /**
     * @var array<string, string[]>
     */
    private array $edges = [];

    private string $entryPoint = 'START';

    private string $endPoint = 'END';

    /**
     * @var class-string
     */
    private string $stateClass;

    public function __construct(string $stateClass)
    {
        $this->stateClass = $stateClass;
    }

    /**
     * Add a new node to the graph
     *
     * @param  string  $name  The name of the node
     * @param  Node  $node  The class to be executed when this node is reached
     */
    public function addNode(string $name, Node $node): self
    {
        if (isset($this->nodes[$name])) {
            throw new InvalidArgumentException("Node with name $name already exists in the graph");
        }

        $this->nodes[$name] = $node;

        return $this;
    }

    /**
     * Add an edge between two nodes
     *
     * @param  string  $from  The name of the source node
     * @param  string  $to  The name of the destination node
     */
    public function addEdge(string $from, string $to): self
    {
        if (! isset($this->nodes[$from])) {
            throw new InvalidArgumentException("Node with name $from does not exist in the graph");
        }

        if (! isset($this->nodes[$to])) {
            throw new InvalidArgumentException("Node with name $to does not exist in the graph");
        }

        if (! isset($this->edges[$from])) {
            $this->edges[$from] = [];
        }

        $this->edges[$from][] = $to;

        return $this;
    }

    /**
     * Set the entry point of the graph
     *
     * @param  string  $nodeName  The name of the node to set as entry point
     */
    public function setEntryPoint(string $nodeName): self
    {
        if (! isset($this->nodes[$nodeName])) {
            throw new InvalidArgumentException("Node with name $nodeName does not exist in the graph");
        }

        $this->entryPoint = $nodeName;

        return $this;
    }

    /**
     * Set the end point of the graph
     *
     * @param  string  $nodeName  The name of the node to set as end point
     */
    public function setEndPoint(string $nodeName): self
    {
        if (! isset($this->nodes[$nodeName])) {
            throw new InvalidArgumentException("Node with name $nodeName does not exist in the graph");
        }

        $this->endPoint = $nodeName;

        return $this;
    }

    public function compile(?Checkpointer $checkpointer = null): object
    {
        $checkpointer = $checkpointer ?? new NullCheckpointer;

        $this->validateGraph();

        // Create a map of node names to their functions
        $nodeFunctions = [];
        foreach ($this->nodes as $nodeName => $node) {
            $nodeFunctions[$nodeName] = function ($state) use ($nodeName, $node, $checkpointer) {
                $result = $node->execute($state);
                $checkpointer->save($nodeName, $state);

                return $result;
            };
        }

        // Create transition functions
        $transitions = $this->createTransitions();

        // Create the final runnable
        return new class($nodeFunctions, $transitions, $this->entryPoint, $this->endPoint, $this->stateClass)
        {
            private $nodeFunctions;

            private $transitions;

            private $entryPoint;

            private $endPoint;

            private $stateClass;

            public function __construct($nodeFunctions, $transitions, $entryPoint, $endPoint, $stateClass)
            {
                $this->nodeFunctions = $nodeFunctions;
                $this->transitions = $transitions;
                $this->entryPoint = $entryPoint;
                $this->endPoint = $endPoint;
                $this->stateClass = $stateClass;
            }

            public function invoke($input)
            {
                $state = new $this->stateClass($input);
                $currentNode = $this->entryPoint;

                while ($currentNode !== $this->endPoint) {
                    $nodeFunction = $this->nodeFunctions[$currentNode];
                    $result = $nodeFunction($state);
                    $state->update($result);

                    $transitionFunction = $this->transitions[$currentNode];
                    $nextNode = $transitionFunction($state);
                    $currentNode = $nextNode;
                }

                return $state->getFinalOutput();
            }
        };
    }

    /**
     * @throws NodeIsNotReachableException
     */
    private function validateGraph(): void
    {
        // Check if all nodes are connected
        $visited = [];
        $this->dfs($this->entryPoint, $visited);

        foreach ($this->nodes as $nodeName => $node) {
            if (! isset($visited[$nodeName])) {
                throw new NodeIsNotReachableException("Node '$nodeName' is not reachable from the entry point.");
            }
        }

        // Check if end point is reachable
        if (! isset($visited[$this->endPoint])) {
            throw new NodeIsNotReachableException('End point is not reachable from the entry point.');
        }
    }

    private function dfs($node, &$visited): void
    {
        $visited[$node] = true;
        if (isset($this->edges[$node])) {
            foreach ($this->edges[$node] as $nextNode) {
                if (! isset($visited[$nextNode])) {
                    $this->dfs($nextNode, $visited);
                }
            }
        }
    }

    private function createTransitions(): array
    {
        $transitions = [];
        foreach ($this->nodes as $nodeName => $node) {
            if (isset($this->edges[$nodeName])) {
                $transitions[$nodeName] = function ($state) use ($nodeName) {
                    return $this->edges[$nodeName][0];
                };
            } else {
                $transitions[$nodeName] = function ($state) {
                    return $this->endPoint;
                };
            }
        }

        return $transitions;
    }
}
