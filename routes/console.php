<?php

use App\Jobs\ScheduledProjectRunJob;
use App\Models\Project;
use Illuminate\Support\Facades\Schedule;

$projects = Project::query()
    ->whereNotNull('cron_expression')
    ->where('enabled', true)
    ->get();

foreach ($projects as $project) {
    Schedule::job(new ScheduledProjectRunJob($project))
        ->cron($project->cron_expression);
}
