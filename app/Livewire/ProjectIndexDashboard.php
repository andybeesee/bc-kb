<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;

class ProjectIndexDashboard extends Component
{
    public $updating = null;

    public function render()
    {
        $currentProjects = Project::with('team')
            ->whereIn('status', [
                'planning',
                'planned',
                'in_progress',
                'late',
            ])
            ->where('owner_id', auth()->user()->id)
            ->get();

        $pastDueTasks = Task::incomplete()
            ->with('project')
            ->where('due_date', '<', date('Y-m-d'))
            ->where('assigned_to', auth()->user()->id)
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
            ->where('assigned_to', auth()->user()->id)
            ->get();

        $incompleteTasks = Task::incomplete()
            ->with('project')
            ->whereNull('due_date')
            ->where('assigned_to', auth()->user()->id)
            ->get();

        return view('livewire.project-index-dashboard')
            ->with('currentProjects', $currentProjects)
            ->with('pastDueTasks', $pastDueTasks)
            ->with('upcomingDueTasks', $upcomingDueTasks)
            ->with('incompleteTasks', $incompleteTasks);
    }
}
