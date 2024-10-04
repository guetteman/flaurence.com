<?php

namespace Database\Factories;

use App\Domain\Graphs\Newsletter\NewsletterGraph;
use App\Enums\FlowOutputTypeEnum;
use App\InputSchemas\NewsletterInput;
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
            'external_id' => NewsletterGraph::ID,
            'name' => $this->faker->sentence,
            'short_description' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'version' => '1.0.0',
            'enabled' => true,
            'input_schema' => NewsletterInput::schema(),
            'output_type' => FlowOutputTypeEnum::Markdown,
        ];
    }

    public function enabled(): FlowFactory
    {
        return $this->state([
            'enabled' => true,
        ]);
    }

    public function disabled(): FlowFactory
    {
        return $this->state([
            'enabled' => false,
        ]);
    }
}
