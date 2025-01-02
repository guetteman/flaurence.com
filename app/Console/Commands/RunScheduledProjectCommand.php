<?php

namespace App\Console\Commands;

use App\Jobs\ScheduledProjectRunJob;
use App\Models\Project;
use Carbon\Carbon;
use Cron\CronExpression;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class RunScheduledProjectCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-scheduled-project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run scheduled projects';

    public function handle()
    {
        Project::query()
            ->where('enabled', true)
            ->where('cron_expression', '!=', null)
            ->whereHas('user', function (Builder $query) {
                $query->where('credits', '>', 0);
            })
            ->get()
            ->each(function (Project $project) {
                $lastRun = $project->runs()->latest()->first();
                $cron = new CronExpression($project->cron_expression);

                $previousRunDate = Carbon::parse($cron->getPreviousRunDate()->format('Y-m-d H:i:s'));

                if ($lastRun->created_at->lt($previousRunDate)) {
                    ScheduledProjectRunJob::dispatch($project);
                }
            });
    }
}
