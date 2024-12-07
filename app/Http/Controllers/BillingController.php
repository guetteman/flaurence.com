<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlanResource;
use App\Http\Resources\SubscriptionResource;
use App\Models\Plan;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use LemonSqueezy\Laravel\Checkout;
use LemonSqueezy\Laravel\Subscription;

class BillingController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        /** @var Subscription $activeSubscription */
        $activeSubscription = auth()->user()->subscriptions()->latest()->first();

        return inertia('Settings/BillingPage', [
            'plans' => PlanResource::collection(
                Plan::query()->active()->get()
            ),
            'activePlan' => PlanResource::make(
                Plan::query()
                    ->where('external_variant_id', $activeSubscription->variant_id) // @phpstan-ignore-line
                    ->first()
            ),
            'activeSubscription' => SubscriptionResource::make(
                auth()->user()->subscriptions()->latest()->first()
            ),
        ]);
    }

    // @pest-mutate-ignore
    public function store(Request $request, string $variant_id): Checkout
    {
        return $request->user()->subscribe(
            variant: $variant_id,
            options: [
                'email' => $request->user()->email,
            ],
            custom: [
                'user_id' => (string) $request->user()->id,
            ]
        );
    }
}
