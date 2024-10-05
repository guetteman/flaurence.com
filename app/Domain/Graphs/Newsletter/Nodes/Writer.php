<?php

namespace App\Domain\Graphs\Newsletter\Nodes;

use App\Domain\Graphs\Newsletter\NewsletterState;
use App\Domain\LaraChain\Message;
use App\Domain\LaraChain\OpenAILLM;
use App\Domain\LaraChain\PromptTemplate;
use App\Domain\LaraGraph\Node;
use App\Domain\LaraGraph\State;

/**
 * @extends Node<NewsletterState>
 */
class Writer extends Node
{
    public function execute($state): State
    {
        $state->output = $this->writeNewsletter($state);

        return $state;
    }

    protected function writeNewsletter(NewsletterState $state): string
    {
        $instructions = $this->instructions();
        $references = $this->formatReferences($state);
        $topic = $state->topic;

        $llm = new OpenAILLM(model: 'o1-preview');

        $systemPrompt = '
        You are a helpful assistant that writes a newsletter for a given topic.
        Your goal is to write a newsletter that is informative, engaging, and relevant to the topic.
        You should include a summary of the content, as well as any important references or citations.
        The newsletter should be concise and to the point, with a focus on the topic.
        Do not include any unnecessary information or irrelevant content.
        Keep the tone of the newsletter professional and informative.
        Make sure to include any relevant links or citations in the newsletter.
        The current date is {date}.
        ';

        $promptTemplate = PromptTemplate::fromMessages([
            //            Message::make('system', "{$systemPrompt}"),
            Message::make('user', "{$references}\n\n{$instructions}\n\n"),
        ]);

        return $llm->generate($promptTemplate->formatPrompt([
            'topic' => $topic,
            'date' => now()->toFormattedDayDateString(),
        ]));
    }

    protected function formatReferences(NewsletterState $state): string
    {
        $formatedRefs = '';
        foreach ($state->summarizedPages as $page) {
            $formatedRef = "[START]\nURL: {$page['url']}\nSummary: {$page['content']}\n[END]";
            $formatedRefs .= $formatedRef."\n";
        }

        return $formatedRefs;
    }

    protected function instructions(): string
    {
        return '
            Use the references above to write an engaging newsletter about {topic}.
            Each reference start at [START] and end at [END].
            You are a helpful assistant that writes a newsletter for a given topic.
            Your goal is to write a newsletter that is informative, engaging, and relevant to the topic.
            You should include a summary of the content, as well as any important references or citations.
            The newsletter should be concise and to the point, with a focus on the topic.
            Do not include any unnecessary information or irrelevant content.
            Keep the tone of the newsletter professional and informative.
            Make sure to include any relevant links or citations in the newsletter.
            The current date is {date}.
        ';
    }
}
