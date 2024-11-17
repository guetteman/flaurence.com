<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
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
            'cron_expression' => $request->string('cron_expression'),
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

    public function edit(Project $project): Response|ResponseFactory
    {
        $flows = Flow::query()
            ->where('enabled', true)
            ->get();

        return inertia('Projects/EditPage', [
            'project' => new ProjectResource($project->load('flow')),
            'flows' => FlowResource::collection($flows),
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $project->update([
            'name' => $request->string('name'),
            'input' => $request->input('input'),
            'cron_expression' => $request->string('cron_expression'),
        ]);

        return redirect()->route('projects.show', $project);
    }
}
