<?php

namespace App\Http\Controllers;

use App\Models\Flow;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class ProjectController extends Controller
{
    public function create(): Response
    {
        $flows = Flow::query()
            ->where('enabled', true)
            ->get();

        return inertia('Projects/CreatePage', [
            'flows' => $flows,
        ]);
    }

    public function store(): RedirectResponse
    {
        request()->validate([
            'name' => ['required', 'string'],
            'flow_id' => ['required', 'exists:flows,id'],
            'input' => ['array'],
        ]);

        $flow = Flow::query()->findOrFail(request('flow_id'));

        $project = $flow->projects()->create([
            'user_id' => auth()->id(),
            'name' => request('name'),
            'input' => request('input'),
            'enabled' => true,
        ]);

        return redirect()->route('dashboard', $project);
    }
}
