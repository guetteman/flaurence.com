<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'enabled' => true,
            'topic' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'urls' => [],
            'cron_expression' => '0 0 * * *',
            'timezone' => 'UTC',
            'user_id' => User::factory(),
        ];
    }
}
