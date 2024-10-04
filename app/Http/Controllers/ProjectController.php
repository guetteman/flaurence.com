<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Resources\FlowResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\RunResource;
use App\Models\Flow;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class ProjectController extends Controller
{
    public function create(): Response|ResponseFactory
    {
        $flows = Flow::query()
            ->where('enabled', true)
            ->get();

        return inertia('Projects/CreatePage', [
            'flows' => FlowResource::collection($flows),
        ]);
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $flow = Flow::query()->findOrFail($request->integer('flow_id'));

        $flow->projects()->create([
            'user_id' => auth()->id(),
            'name' => $request->string('name'),
            'input' => $request->input('input'),
            'enabled' => true,
        ]);

        return redirect()->route('dashboard');
    }

    public function show(Project $project): Response|ResponseFactory
    {
        $runs = $project->runs()->latest()->get();

        return inertia('Projects/ShowPage', [
            'project' => new ProjectResource($project->load('flow')),
            'runs' => RunResource::collection($runs),
        ]);
    }
}
