<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskIndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $q = Task::with(['project', 'checklist', 'assignedTo', 'completedBy'])
            ->withCount(['files', 'comments']);

        if($request->filled('project')) {
            $q = $q->where('project_id', $request->get('project'));
        }

        if($request->filled('checklist')) {
            $q = $q->where('checklist_id', $request->get('checklist'));
        }

        if($request->filled('team')) {
            // TODO: team filter?
        }

        if($request->filled('assigned')) {
            $q = $q->where('assigned_to', $request->get('assigned'));
        }

        foreach($request->get('filters', []) as $filterName) {
            switch ($filterName) {
                case 'past_due':
                    $q = $q->incomplete()->where('due_date', '<', date('Y-m-d'));
                    break;
                case 'incomplete':
                    $q = $q->incomplete();
                    break;
                case 'upcoming':
                    // anything due between today and the next weeks
                    $q = $q->incomplete()
                        ->whereBetween('due_date', [date('Y-m-d'), date('Y-m-d', strtotime('+2 weeks'))]);
                    break;
            }
        }

        return $q->get();
    }
}
