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

        $pastDueTasks = Task::incomplete()
            ->with('project')
            ->where('due_date', '<', date('Y-m-d'))
            ->where('assigned_to', $request->user()->id)
            ->orderBy('due_date', 'ASC')
            ->get();

        $upcomingDueTasks = Task::incomplete()
            ->with('project')
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [
                date('Y-m-d'),
                date('Y-m-d', strtotime('+2 weeks'))
            ])
            ->orderBy('due_date', 'ASC')
            ->where('assigned_to', $request->user()->id)
            ->get();

        $incompleteTasks = Task::incomplete()
            ->with('project')
            ->whereNull('due_date')
            ->where('assigned_to', $request->user()->id)
            ->get();

        return view('dashboard')
            ->with('pastDueTasks', $pastDueTasks)
            ->with('upcomingDueTasks', $upcomingDueTasks)
            ->with('incompleteTasks', $incompleteTasks)
            ->with('currentProjects', $currentProjects)
            ->with('teams', $teams);
    }
}
