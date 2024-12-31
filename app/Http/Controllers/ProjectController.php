<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\RunResource;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class ProjectController extends Controller
{
    public function create(): Response|ResponseFactory
    {
        return inertia('Projects/CreatePage');
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        Project::create([
            'user_id' => auth()->id(),
            'name' => $request->string('name'),
            'topic' => $request->string('topic'),
            'description' => $request->string('description'),
            'urls' => $request->input('urls'),
            'enabled' => true,
            'cron_expression' => $request->string('cron_expression'),
        ]);

        return redirect()->route('dashboard');
    }

    public function show(Project $project): Response|ResponseFactory
    {
        $runs = $project->runs()->latest()->get();

        return inertia('Projects/ShowPage', [
            'project' => new ProjectResource($project),
            'runs' => RunResource::collection($runs),
        ]);
    }

    public function edit(Project $project): Response|ResponseFactory
    {
        return inertia('Projects/EditPage', [
            'project' => new ProjectResource($project),
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $project->update([
            'name' => $request->string('name'),
            'topic' => $request->string('topic'),
            'description' => $request->string('description'),
            'urls' => $request->input('urls'),
            'cron_expression' => $request->string('cron_expression'),
        ]);

        return redirect()->route('projects.show', $project);
    }
}
