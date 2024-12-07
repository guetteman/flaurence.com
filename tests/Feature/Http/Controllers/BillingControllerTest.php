<?php

use App\Http\Controllers\BillingController;
use App\Models\Plan;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

covers(BillingController::class);

describe('BillingController', function () {
    it('should show billing page', function () {
        $plan = Plan::factory()->create();

        $this
            ->actingAs(User::factory()->create())
            ->get(route('billing.index'))
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Settings/BillingPage')
                ->has('plans.data.0', fn (AssertableInertia $page) => $page
                    ->where('id', $plan->id)
                    ->where('name', $plan->name)
                    ->where('type', $plan->type->value)
                    ->where('external_product_id', $plan->external_product_id)
                    ->where('external_variant_id', $plan->external_variant_id)
                    ->where('description', $plan->description)
                    ->where('price', $plan->price)
                    ->where('formatted_price', $plan->formatted_price)
                    ->where('active', $plan->active)
                )
            );
    });
});
