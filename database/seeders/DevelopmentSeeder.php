<?php

namespace Database\Seeders;

use App\Enums\PlanTypeEnum;
use App\Models\Flow;
use App\Models\Plan;
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

        Plan::factory()->create([
            'external_product_id' => '402912',
            'external_variant_id' => '613772',
            'name' => 'Basic',
            'description' => 'A basic plan with a free trial',
            'type' => PlanTypeEnum::Monthly,
            'price' => 499,
        ]);

        Plan::factory()->create([
            'external_product_id' => '402912',
            'external_variant_id' => '613774',
            'name' => 'Basic',
            'description' => 'Yearly subscription',
            'type' => PlanTypeEnum::Yearly,
            'price' => 4999,
        ]);

        Plan::factory()->create([
            'external_product_id' => '402916',
            'external_variant_id' => '613778',
            'name' => 'Pro',
            'description' => 'Monthly subscription',
            'type' => PlanTypeEnum::Monthly,
            'price' => 1499,
        ]);

        Plan::factory()->create([
            'external_product_id' => '402916',
            'external_variant_id' => '613781',
            'name' => 'Pro',
            'description' => 'Yearly subscription',
            'type' => PlanTypeEnum::Yearly,
            'price' => 14999,
        ]);
    }
}
