<?php

namespace App\Http\Controllers;

use App\Actions\Projects\GetUserProjects;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class DashboardController extends Controller
{
    public function index(GetUserProjects $getUserProjects): Response|ResponseFactory|RedirectResponse
    {
        $projects = $getUserProjects->execute(auth()->user());

        return inertia('DashboardPage', [
            'projects' => ProjectResource::collection($projects),
        ]);
    }
}
