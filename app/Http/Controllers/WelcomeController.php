<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlanResource;
use App\Models\Plan;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        $activePlans = Plan::where('active', true)->get();

        return inertia('WelcomePage', [
            'activePlans' => PlanResource::collection($activePlans),
        ]);
    }
}
