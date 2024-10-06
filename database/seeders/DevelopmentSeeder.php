<?php

namespace Database\Seeders;

use App\Models\Flow;
use App\Models\User;
use Illuminate\Database\Seeder;

class DevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => 'user@flaurence.test',
        ]);

        Flow::factory()->create([
            'name' => 'Personal Newsletter',
            'short_description' => 'A personalized newsletter with your favorite links',
            'description' => 'This flow generates a personalized newsletter with your favorite links',
        ]);
    }
}
