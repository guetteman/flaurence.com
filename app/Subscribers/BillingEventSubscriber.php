<?php

namespace App\Subscribers;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Events\Dispatcher;
use LemonSqueezy\Laravel\Events\SubscriptionCreated;

class BillingEventSubscriber
{
    public function handleSubscriptionCreatedEvent(SubscriptionCreated $event): void
    {
        /** @var User $user */
        $user = $event->billable;

        $plan = Plan::query()
            ->where('external_variant_id', $event->subscription->variant_id)
            ->first();

        if (! $plan) {
            return;
        }

        $user->update([
            'credits' => $plan->credits,
        ]);
    }

    /**
     * @return array<string, string>
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            SubscriptionCreated::class => 'handleSubscriptionCreatedEvent',
        ];
    }
}
