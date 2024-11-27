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
});
