<?php

namespace App\Actions\Projects;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;

class GetUserProjects
{
    /**
     * @return Collection<int, Project>
     */
    public function execute(User $user): Collection
    {
        return $user
            ->projects()
            ->with('flow')
            ->get();
    }
}
