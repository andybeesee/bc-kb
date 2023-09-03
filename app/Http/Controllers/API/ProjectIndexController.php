<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectIndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $q = Project::with(['team', 'owner'])
            ->withCount([
                'tasks',
                'pastDueTasks',
                'incompleteTasks',
                'incompleteUserTasks',
            ]);

        // TODO: Search, sort
        // TODO: filters - complete/incomplete/whatever else

        return $q->paginate($request->get('per_page', 50));
    }
}
