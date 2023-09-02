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
            ->withCount(['pastDueTasks', 'incompleteTasks']);

        // TODO: Search, sort
        // TODO: filters - complete/incomplete/whatever else

        return $q->paginate(50);
    }
}