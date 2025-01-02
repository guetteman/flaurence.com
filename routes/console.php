<?php

use App\Console\Commands\RunScheduledProjectCommand;
use Illuminate\Support\Facades\Schedule;

Schedule::command(RunScheduledProjectCommand::class)->everyFiveMinutes();
