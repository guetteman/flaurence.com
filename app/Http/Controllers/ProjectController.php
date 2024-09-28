<?php

namespace App\Http\Controllers;

use App\Models\Flow;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class ProjectController extends Controller
{
    public function create(): Response
    {
        $flows = Flow::query()
            ->where('enabled', true)
            ->get();

        return inertia('Projects/CreatePage', [
            'flows' => $flows,
        ]);
    }

    public function store(): RedirectResponse
    {
        request()->validate([
            'name' => ['required', 'string'],
            'short_description' => ['required', 'string'],
            'description' => ['required', 'string'],
            'flow_id' => ['required', 'exists:flows,id'],
        ]);

        $flow = Flow::query()->findOrFail(request('flow_id'));

        $project = $flow->projects()->create([
            'name' => request('name'),
            'short_description' => request('short_description'),
            'description' => request('description'),
        ]);

        return redirect()->route('projects.show', $project);
    }
}
