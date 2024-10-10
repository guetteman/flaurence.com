<?php

use App\Domain\Graphs\Subscribers\GraphEventSubscriber;
use App\Domain\LaraChain\Events\LLMExecutedEvent;
use App\Models\Run;

describe('GraphEventSubscriber - handleLLMExecutedEvent', function () {
    it('calculates spent credits', function () {
        $run = Run::factory()->create(['spent_credits' => 0]);
        $event = new LLMExecutedEvent(
            id: (string) $run->id,
            provider: 'openai',
            model: 'gpt-4o',
            usage: ['total_tokens' => 51300],
        );

        (new GraphEventSubscriber)->handleLLMExecutedEvent($event);

        expect($run->refresh()->spent_credits)->toBe(6);
    });
});
