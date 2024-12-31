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
        /** @var Subscription|null $activeSubscription */
        $activeSubscription = auth()->user()->subscriptions()->latest()->first();
        $activePlan = null;
        if ($activeSubscription) {
            $activePlan = Plan::query()
                ->where('external_variant_id', $activeSubscription->variant_id) // @phpstan-ignore-line
                ->first();
        }

        return inertia('Settings/BillingPage', [
            'plans' => PlanResource::collection(Plan::query()->active()->get()),
            'activePlan' => $activePlan ? new PlanResource($activePlan) : null,
            'activeSubscription' => $activeSubscription ? new SubscriptionResource($activeSubscription) : null,
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
