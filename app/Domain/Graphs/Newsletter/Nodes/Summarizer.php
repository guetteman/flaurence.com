<?php

namespace App\Domain\Graphs\Newsletter\Nodes;

use App\Domain\Graphs\Newsletter\NewsletterState;
use App\Domain\LaraChain\Message;
use App\Domain\LaraChain\OpenAILLM;
use App\Domain\LaraChain\PromptTemplate;
use App\Domain\LaraGraph\Node;

/**
 * @extends Node<NewsletterState>
 */
class Summarizer extends Node
{
    public function execute($state): NewsletterState
    {
        $state->summarizedPages = $this->summarizePages($state->crawledPages);

        return $state;
    }

    protected function summarizePages(array $pages): array
    {
        $summaries = [];
        foreach ($pages as $pageData) {
            $summaries[] = $this->summarizePage($pageData['topic'], $pageData);
        }

        return $summaries;
    }

    protected function summarizePage(string $topic, array $pageData): array
    {
        $llm = new OpenAILLM;

        $systemPrompt = '
        You have been tasked with summarizing the content of a markdown content. Be concise, and share the key points
        from the content.
        ';
        $prompt = '
            Given the following page information,
            provide a summary of the content of the page and how it is related to the provided topic.
            Be sure to add any important reference links or citations:
            Topic: {topic}
            Page
            url: {url}
            content: {content}
        ';

        $promptTemplate = PromptTemplate::fromMessages([
            Message::make('system', "{$systemPrompt}"),
            Message::make('user', "{$prompt}"),
        ]);

        $response = $llm->generate($promptTemplate->formatPrompt([
            'topic' => $topic,
            'url' => $pageData['url'],
            'content' => $pageData['content'],
        ]));

        return [
            'url' => $pageData['url'],
            'content' => $response,
        ];
    }
}
