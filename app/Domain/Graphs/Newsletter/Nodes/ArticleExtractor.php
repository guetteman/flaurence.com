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
class ArticleExtractor extends Node
{
    /**
     * @param  NewsletterState  $state
     */
    public function execute($state): NewsletterState
    {
        $state->summarizedPages = $this->extractPagesData($state);

        return $state;
    }

    /**
     * @return array<array<string, string>>
     */
    protected function extractPagesData(NewsletterState $state): array
    {
        $pagesData = [];
        foreach ($state->crawledPages as $pageData) {
            $pagesData[] = $this->extractPageData($state, $pageData);
        }

        return $pagesData;
    }

    /**
     * @param  array<string, string>  $pageData
     * @return array<string, string>
     */
    protected function extractPageData(NewsletterState $state, array $pageData): array
    {
        $llm = new OpenAILLM(id: $state->graphId, model: 'gpt-4o');

        $systemPrompt = '
        You have been tasked with extracting articles information from a blog page in html format. Be concise.
        The current date is {date}.
        ';

        $prompt = '
            Given the following page information,
            extract the articles information from the page and how they are related to "{topic}" topic.
            Be sure to add any important reference links or citations.

            HTML content:
            {content}

            Notes:
            - You can only add articles that are related to the topic.
            - You can only add articles that have a title, date, and url.

            Follow the structure below:

            Article 1:
            Title: [The title of the article]
            Date: [The date the article was published]
            Description: [The short description of the article]
            Url: [The url of the article]

            Article 2:
            ...
        ';

        $promptTemplate = PromptTemplate::fromMessages([
            Message::make('system', "{$systemPrompt}"),
            Message::make('user', "{$prompt}"),
        ]);

        $response = $llm->generate($promptTemplate->formatPrompt([
            'topic' => $state->topic,
            'content' => strlen($pageData['content']) > 30000 ? substr($pageData['content'], 0, 30000) : $pageData['content'],
            'date' => now()->toFormattedDayDateString(),
        ]));

        return [
            'url' => $pageData['url'],
            'content' => $response,
        ];
    }
}
