<?php

namespace Database\Factories;

use App\Enums\RunStatusEnum;
use App\Models\Project;
use App\Models\Run;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Run>
 */
class RunFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => RunStatusEnum::Queued,
            'output' => [],
            'error' => null,
            'project_id' => Project::factory(),
        ];
    }
}
