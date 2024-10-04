<?php

namespace App\Domain\Graphs\Newsletter;

use App\Domain\Graphs\Newsletter\Nodes\Crawler;
use App\Domain\Graphs\Newsletter\Nodes\Summarizer;
use App\Domain\Graphs\Newsletter\Nodes\Writer;
use App\Domain\LaraGraph\StateGraph;

class NewsletterGraph
{
    public const ID = 'newsletter';

    public function invoke(array $input)
    {
        $graph = new StateGraph(NewsletterState::class);

        $graph
            ->addNode('Crawl Urls', new Crawler)
            ->addNode('Summarize Pages', new Summarizer)
            ->addNode('Write Newsletter', new Writer)
            ->addEdge(StateGraph::START, 'Crawl Urls')
            ->addEdge('Crawl Urls', 'Summarize Pages')
            ->addEdge('Summarize Pages', 'Write Newsletter')
            ->addEdge('Write Newsletter', StateGraph::END);

        $workflow = $graph->compile();

        return $workflow->invoke($input);
    }
}
