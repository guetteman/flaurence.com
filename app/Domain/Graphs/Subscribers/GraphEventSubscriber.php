<?php

namespace App\Domain\Graphs\Subscribers;

use App\Domain\LaraChain\Events\LLMExecutedEvent;
use App\Domain\Tools\DocumentLoaders\Events\FireCrawlLoaderExecutedEvent;
use App\Models\Run;
use Illuminate\Events\Dispatcher;

class GraphEventSubscriber
{
    public function handleLLMExecutedEvent(LLMExecutedEvent $event): void
    {
        $run = Run::find((int) $event->id);

        if (! $run) {
            return;
        }

        $run->spent_credits += data_get($event->usage, 'total_tokens', 0);
        $run->save();
    }

    public function handleFireCrawlLoaderExecutedEvent(FireCrawlLoaderExecutedEvent $event): void
    {
        $run = Run::find((int) $event->id);

        if (! $run) {
            return;
        }

        $run->spent_credits += $event->totalPagesLoaded;
        $run->save();
    }

    /**
     * @return array<string, string>
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            LLMExecutedEvent::class => 'handleLLMExecutedEvent',
            FireCrawlLoaderExecutedEvent::class => 'handleFireCrawlLoaderExecutedEvent',
        ];
    }
}
