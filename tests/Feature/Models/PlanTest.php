<?php

use App\Enums\PlanTypeEnum;
use App\Models\Plan;

describe('Plan model', function () {
    it('should cast type to PlanTypeEnum', function () {
        $plan = Plan::factory()->create([
            'type' => PlanTypeEnum::Monthly->value,
        ]);

        expect($plan->type)->toBeInstanceOf(PlanTypeEnum::class);
    });

    it('should cast active column to boolean', function () {
        $plan = Plan::factory()->create([
            'active' => 1,
        ]);

        expect($plan->active)->toBeTrue();
    });

    it('should return formatted price', function () {
        $plan = Plan::factory()->create([
            'price' => 499,
        ]);

        expect($plan->formatted_price)->toBe('4.99');
    });

    it('should filter active plans', function () {
        Plan::factory()->create([
            'active' => 1,
        ]);

        $activePlans = Plan::active()->get();

        expect($activePlans)->toHaveCount(1);
    });
});
