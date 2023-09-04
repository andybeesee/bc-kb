<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectIndexController extends Controller
{
    public const CURRENT_PROJECT_STATUSES = [
        'planning',
        'planned',
        'in_progress',
        'late',
    ];

    public function __invoke(Request $request)
    {
        $q = Project::with([
                'team',
                'owner',
                'currentStatus',
                'currentStatus.creator',
            ])
            ->withCount([
                'tasks',
                'pastDueTasks',
                'incompleteTasks',
                'incompleteUserTasks',
            ]);

        if($request->filled('search')) {
            $q = $q->where('name', 'LIKE', "%".$request->get('search')."%");
        }

        switch ($request->get('filter', null)) {
            case 'user_current':
                $q = $q->whereIn('status', static::CURRENT_PROJECT_STATUSES)->where('owner_id', auth()->user()->id);
                break;
        }
        // TODO: Search, sort
        // TODO: filters - complete/incomplete/whatever else

        return $q->paginate($request->get('per_page', 50));
    }
}
