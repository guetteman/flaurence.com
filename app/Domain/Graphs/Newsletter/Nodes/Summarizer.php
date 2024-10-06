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
        $state->summarizedPages = $this->summarizePages($state->crawledPages, $state->topic);

        return $state;
    }

    /**
     * @param  array<array<string, string>>  $pages
     * @return array<array<string, string>>
     */
    protected function summarizePages(array $pages, string $topic): array
    {
        $summaries = [];
        foreach ($pages as $pageData) {
            $summaries[] = $this->summarizePage($topic, $pageData);
        }

        return $summaries;
    }

    /**
     * @param  array<string, string>  $pageData
     * @return array<string, string>
     */
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

            The summary structure should be:
            Url: [The url of the page]
            Title: [The title of the page]
            Date: [The date the page was published if available, otherwise set to N/A]
            Summary: [The summary of the page content with no more than 5000]
        ';

        $promptTemplate = PromptTemplate::fromMessages([
            Message::make('system', "{$systemPrompt}"),
            Message::make('user', "{$prompt}"),
        ]);

        $response = $llm->generate($promptTemplate->formatPrompt([
            'topic' => $topic,
            'url' => $pageData['url'],
            'content' => strlen($pageData['content']) > 30000 ? substr($pageData['content'], 0, 30000) : $pageData['content'],
        ]));

        return [
            'url' => $pageData['url'],
            'content' => $response,
        ];
    }
}
