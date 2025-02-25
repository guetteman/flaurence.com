<?php

namespace App\Http\Controllers;

use App\Enums\RunStatusEnum;
use App\Http\Resources\RunResource;
use App\Jobs\ProjectRunJob;
use App\Models\Project;
use App\Models\Run;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class RunController extends Controller
{
    public function store(Project $project): RedirectResponse
    {
        $run = $project->runs()->create([
            'status' => RunStatusEnum::Queued,
        ]);

        ProjectRunJob::dispatch($run);

        return redirect()->route('projects.show', $project);
    }

    public function show(Project $project, Run $run): Response|ResponseFactory
    {
        return inertia('Runs/ShowPage', [
            'run' => RunResource::make($run->load('project')),
        ]);
    }
}
