<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectStatusController extends Controller
{
    public function index()
    {
        return config('statuses');
    }

    public function update(Request $request, Project $project)
    {
        $statuses = array_keys(config('statuses'));
        $this->validate($request, [
            'status' => 'required|in:'.implode(',', $statuses),
        ]);

        $project->status = $request->get('status');
        $project->save();

        return $project->fresh();
    }
}
