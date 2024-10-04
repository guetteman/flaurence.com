<?php

namespace App\Http\Controllers;

use App\Jobs\ProjectRunJob;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;

class RunController extends Controller
{
    public function store(Project $project): RedirectResponse
    {
        ProjectRunJob::dispatch($project);

        return redirect()->route('projects.show', $project);
    }
}
