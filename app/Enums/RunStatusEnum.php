<?php

namespace App\Enums;

enum RunStatusEnum: string
{
    case Queued = 'queued';
    case Running = 'running';
    case Completed = 'completed';
    case Failed = 'failed';
}
