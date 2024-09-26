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

        Flow::factory()->count(3)->create();
    }
}
