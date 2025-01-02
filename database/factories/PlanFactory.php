<?php

namespace Database\Factories;

use App\Enums\PlanTypeEnum;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'external_product_id' => $this->faker->uuid(),
            'external_variant_id' => $this->faker->uuid(),
            'type' => $this->faker->randomElement([PlanTypeEnum::Monthly, PlanTypeEnum::Yearly]),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomNumber(4),
            'credits' => $this->faker->randomNumber(3),
            'active' => true,
        ];
    }
}
