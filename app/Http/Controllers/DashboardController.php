<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $teams = $request->user()->teams;

        $currentProjects = Project::with('team')
            ->whereIn('status', [
                'planning',
                'planned',
                'in_progress',
                'late',
            ])
            ->where('owner_id', $request->user()->id)
            ->get();

        $upcomingDueTasks = Task::incomplete()
            ->where('due_date', '<=', date('Y-m-d', strtotime('+2 weeks')))
            ->with(['board', 'board.project'])
            ->orderBy('due_date', 'ASC')
            ->where('assigned_to', $request->user()->id)
            ->get();

        $incompleteTasks = Task::incomplete()
            ->with('board', 'board.project')
            ->whereNull('due_date')
            ->where('assigned_to', $request->user()->id)
            ->get();

        return view('dashboard')
            ->with('upcomingDueTasks', $upcomingDueTasks)
            ->with('incompleteTasks', $incompleteTasks)
            ->with('currentProjects', $currentProjects)
            ->with('teams', $teams);
    }
}
