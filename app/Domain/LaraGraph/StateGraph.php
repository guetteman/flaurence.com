<?php

namespace App\Domain\LaraGraph;

use App\Domain\LaraGraph\Checkpointers\Checkpointer;
use App\Domain\LaraGraph\Checkpointers\NullCheckpointer;
use App\Domain\LaraGraph\Exceptions\NodeIsNotReachableException;
use App\Domain\LaraGraph\Nodes\StartNode;
use InvalidArgumentException;

/**
 * @template TState of State
 */
class StateGraph
{
    const START = 'START';

    const END = 'END';

    /**
     * @var array<string, Node<TState>>
     */
    private array $nodes = [];

    /**
     * @var array<string, string[]>
     */
    private array $edges = [];

    private string $entryPoint = 'START';

    private string $endPoint = 'END';

    /**
     * @var class-string<TState>
     */
    private string $stateClass;

    /**
     * @param  class-string<TState>  $stateClass
     */
    public function __construct(string $stateClass)
    {
        $this->stateClass = $stateClass;

        /** @var StartNode<TState> $startNode */
        $startNode = new StartNode;
        $this->addNode(StateGraph::START, $startNode);
    }

    /**
     * Add a new node to the graph
     *
     * @param  string  $name  The name of the node
     * @param  Node<TState>  $node  The class to be executed when this node is reached
     * @return self<TState>
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
     * @return self<TState>
     */
    public function addEdge(string $from, string $to): self
    {
        if (! isset($this->nodes[$from]) && $from !== StateGraph::START) {
            throw new InvalidArgumentException("Node with name $from does not exist in the graph");
        }

        if (! isset($this->nodes[$to]) && $to !== StateGraph::END) {
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
     * @return self<TState>
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
     * @return self<TState>
     */
    public function setEndPoint(string $nodeName): self
    {
        if (! isset($this->nodes[$nodeName])) {
            throw new InvalidArgumentException("Node with name $nodeName does not exist in the graph");
        }

        $this->endPoint = $nodeName;

        return $this;
    }

    /**
     * @param  Checkpointer<TState>|null  $checkpointer
     * @return StateGraphRunner<TState>
     *
     * @throws NodeIsNotReachableException
     */
    public function compile(?Checkpointer $checkpointer = null): StateGraphRunner
    {
        $checkpointer = $checkpointer ?? $this->getNullCheckpointer();

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

        return new StateGraphRunner($nodeFunctions, $transitions, $this->entryPoint, $this->endPoint, $this->stateClass);
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

    /**
     * @param  array<string, bool>  $visited
     */
    private function dfs(string $nodeName, array &$visited): void
    {
        $visited[$nodeName] = true;
        if (isset($this->edges[$nodeName])) {
            foreach ($this->edges[$nodeName] as $nextNode) {
                if (! isset($visited[$nextNode])) {
                    $this->dfs($nextNode, $visited);
                }
            }
        }
    }

    /**
     * @return array<string, callable(TState): string>
     */
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

    /**
     * @return Checkpointer<TState>
     */
    public function getNullCheckpointer(): Checkpointer
    {
        /** @var Checkpointer<TState> */
        return new NullCheckpointer;
    }
}
