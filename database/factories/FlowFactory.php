<?php

namespace Database\Factories;

use App\Enums\FlowOutputTypeEnum;
use App\Models\Flow;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Flow>
 */
class FlowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'external_id' => $this->faker->uuid,
            'name' => $this->faker->sentence,
            'short_description' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'version' => '1.0.0',
            'enabled' => true,
            'input_schema' => [],
            'output_type' => FlowOutputTypeEnum::Markdown,
        ];
    }
}
