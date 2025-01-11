<?php

namespace App\Domain\Graphs\Subscribers;

use App\Domain\LaraChain\Events\LLMExecutedEvent;
use App\Domain\Tools\DocumentLoaders\Events\FireCrawlLoaderExecutedEvent;
use App\Models\Run;
use Brick\Math\BigDecimal;
use Brick\Math\Exception\DivisionByZeroException;
use Brick\Math\Exception\MathException;
use Brick\Math\Exception\NumberFormatException;
use Brick\Math\RoundingMode;
use Illuminate\Events\Dispatcher;

class GraphEventSubscriber
{
    public function handleLLMExecutedEvent(LLMExecutedEvent $event): void
    {
        $run = Run::find((int) $event->id);

        if (! $run) {
            return;
        }

        $provider = $event->provider;
        $model = $event->model;

        $totalTokens = data_get($event->usage, 'total_tokens', 0);
        $totalTokenCents = BigDecimal::of($totalTokens)
            ->dividedBy(that: 1_000_000, scale: 7, roundingMode: RoundingMode::HALF_UP)
            ->multipliedBy(config("credits.$provider.$model.usd_cents_per_million_tokens"));

        $spentCredits = $totalTokenCents
            ->dividedBy(that: config('credits.flaurence.usd_cents_per_credit'), roundingMode: RoundingMode::UP);

        $run->spent_credits += (int) ceil($spentCredits->toFloat());
        $run->project->user->reduceCredits($run->spent_credits);

        $run->save();
    }

    /**
     * @throws MathException
     * @throws NumberFormatException
     * @throws DivisionByZeroException
     */
    public function handleFireCrawlLoaderExecutedEvent(FireCrawlLoaderExecutedEvent $event): void
    {
        $run = Run::find((int) $event->id);

        if (! $run) {
            return;
        }

        $spentCredits = BigDecimal::of($event->totalPagesLoaded)
            ->multipliedBy(config('credits.firecrawl.usd_cents_per_credit'))
            ->dividedBy(that: config('credits.flaurence.usd_cents_per_credit'), roundingMode: RoundingMode::UP);

        $run->spent_credits += (int) ceil($spentCredits->toFloat());
        $run->project->user->reduceCredits($run->spent_credits);

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
