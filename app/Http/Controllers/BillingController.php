<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlanResource;
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
        ]);
    }

    public function subscribe(Request $request, string $variant_id): Checkout
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
