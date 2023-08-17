<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Task;
use App\Traits\LivewireTaskFunctions;
use Livewire\Component;

class ProjectIndexDashboard extends Component
{
    use LivewireTaskFunctions;

    public $updating = null;

    public $currentProjectsIds;
    public $pastDueTasksIds;
    public $upcomingDueTasksIds;
    public $incompleteTasksIds;

    public function mount()
    {
        $this->pastDueTasksIds = Task::incomplete()
            ->where('due_date', '<', date('Y-m-d'))
            ->where('assigned_to', auth()->user()->id)
            ->orderBy('due_date', 'ASC')
            ->pluck('id')->toArray();

        $this->incompleteTasksIds = Task::incomplete()
            ->whereNull('due_date')
            ->where('assigned_to', auth()->user()->id)
            ->get()->pluck('id')->toArray();

        $this->upcomingDueTasksIds = Task::incomplete()
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [
                date('Y-m-d'),
                date('Y-m-d', strtotime('+2 weeks'))
            ])
            ->orderBy('due_date', 'ASC')
            ->where('assigned_to', auth()->user()->id)
            ->get()
            ->pluck('id')->toArray();
    }

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

        $pastDueTasks = Task::with('project', 'checklist')
            ->whereIn('id', $this->pastDueTasksIds)
            ->get();

        $upcomingDueTasks = Task::whereIn('id', $this->upcomingDueTasksIds)
            ->with('project')
            ->orderBy('due_date', 'ASC')
            ->get();

        $incompleteTasks = Task::with('project')
            ->whereIn('id', $this->incompleteTasksIds)
            ->get();

        return view('livewire.project-index-dashboard')
            ->with('currentProjects', $currentProjects)
            ->with('pastDueTasks', $pastDueTasks)
            ->with('upcomingDueTasks', $upcomingDueTasks)
            ->with('incompleteTasks', $incompleteTasks);
    }
}
