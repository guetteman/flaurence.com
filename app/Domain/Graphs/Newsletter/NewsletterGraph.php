<?php

namespace App\Domain\Graphs\Newsletter;

use App\Domain\Graphs\Newsletter\Nodes\ArticleExtractor;
use App\Domain\Graphs\Newsletter\Nodes\Scraper;
use App\Domain\Graphs\Newsletter\Nodes\Writer;
use App\Domain\LaraGraph\Exceptions\NodeIsNotReachableException;
use App\Domain\LaraGraph\StateGraph;

class NewsletterGraph
{
    public const ID = 'newsletter';

    /**
     * @param  array<string, mixed>  $input
     *
     * @throws NodeIsNotReachableException
     */
    public function invoke(array $input, ?string $id = null): NewsletterState
    {
        $graph = new StateGraph(NewsletterState::class);

        $graph
            ->addNode('Crawl Urls', new Scraper)
            ->addNode('Summarize Pages', new ArticleExtractor)
            ->addNode('Write Newsletter', new Writer)
            ->addEdge(StateGraph::START, 'Crawl Urls')
            ->addEdge('Crawl Urls', 'Summarize Pages')
            ->addEdge('Summarize Pages', 'Write Newsletter')
            ->addEdge('Write Newsletter', StateGraph::END);

        $workflow = $graph->compile();

        return $workflow->invoke($input, $id);
    }
}
