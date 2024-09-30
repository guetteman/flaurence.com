<?php

namespace App\Domain\LaraGraph;

use InvalidArgumentException;

class StateGraph
{
    private array $nodes = [];
    private array $edges = [];
    private string $entryPoint = 'START';
    private string $endPoint = 'END';
    private string $stateClass;

    public function __construct(string $stateClass)
    {
        $this->stateClass = $stateClass;
    }

    /**
     * Add a new node to the graph
     *
     * @param string $name The name of the node
     * @param Node $node The class to be executed when this node is reached
     * @return self
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
     * @param string $from The name of the source node
     * @param string $to The name of the destination node
     * @return self
     */
    public function addEdge(string $from, string $to): self
    {
        if (!isset($this->nodes[$from])) {
            throw new InvalidArgumentException("Node with name $from does not exist in the graph");
        }

        if (!isset($this->nodes[$to])) {
            throw new InvalidArgumentException("Node with name $to does not exist in the graph");
        }

        $this->edges[$from] = $to;
        return $this;
    }

    /**
     * Set the entry point of the graph
     *
     * @param string $nodeName The name of the node to set as entry point
     * @return self
     */
    public function setEntryPoint(string $nodeName): self
    {
        if (!isset($this->nodes[$nodeName])) {
            throw new InvalidArgumentException("Node with name $nodeName does not exist in the graph");
        }

        $this->entryPoint = $nodeName;
        return $this;
    }

    /**
     * Set the end point of the graph
     *
     * @param string $nodeName The name of the node to set as end point
     * @return self
     */
    public function setEndPoint(string $nodeName): self
    {
        if (!isset($this->nodes[$nodeName])) {
            throw new InvalidArgumentException("Node with name $nodeName does not exist in the graph");
        }

        $this->endPoint = $nodeName;
        return $this;
    }
}
