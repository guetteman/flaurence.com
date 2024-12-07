<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlanResource;
use App\Http\Resources\SubscriptionResource;
use App\Models\Plan;
use Illuminate\Http\Request;
use Inertia\Response;
use LemonSqueezy\Laravel\Checkout;

class BillingController extends Controller
{
    public function index(): Response
    {
        return inertia('Settings/BillingPage', [
            'plans' => PlanResource::collection(
                Plan::query()->active()->get()
            ),
            'activePlan' => PlanResource::make(
                Plan::query()
                    ->where('external_variant_id', auth()->user()->subscriptions()->first()->variant_id)
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
