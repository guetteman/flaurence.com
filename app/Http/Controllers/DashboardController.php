<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class DashboardController extends Controller
{
    public function index(): Response|ResponseFactory|RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $projects = $user->projects()->get();

        return inertia('DashboardPage', [
            'projects' => ProjectResource::collection($projects),
        ]);
    }
}
