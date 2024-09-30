<?php

namespace App\Domain\Graphs\Newsletter;

use App\Domain\LaraGraph\StateGraph;

class NewsletterGraph
{
    public function invoke(array $input)
    {
        $graph = new StateGraph(NewsletterState::class);

        //        $graph->addNode(StateGraph::$START)
    }
}
