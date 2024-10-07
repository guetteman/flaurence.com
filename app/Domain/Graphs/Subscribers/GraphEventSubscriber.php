<?php

namespace App\Domain\Graphs\Subscribers;

use App\Domain\LaraChain\Events\LLMExecutedEvent;
use App\Models\Run;
use Illuminate\Events\Dispatcher;

class GraphEventSubscriber
{
    public function handleLLMExecutedEvent(LLMExecutedEvent $event): void
    {
        $run = Run::find($event->id);

        if (! $run) {
            return;
        }

        $run->spent_credits += data_get($event->usage, 'total_tokens', 0);
        $run->save();
    }

    /**
     * @return array<string, string>
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            LLMExecutedEvent::class => 'handleLLMExecutedEvent',
        ];
    }
}
