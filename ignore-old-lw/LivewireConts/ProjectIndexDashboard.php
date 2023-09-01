<?php

namespace ignore-old-lw\Livewire-old-lw\Livewire-old-lw\Livewire;

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

    public $maxSoonDate;

    public function mount()
    {
        $this->maxSoonDate = date('Y-m-d', strtotime('+2 weeks'));
        //we track ids up here, so that when someone completes a task it stays on the dashboard until they refresh
        $this->pastDueTasksIds = Task::incomplete()
            ->where('due_date', '<', date('Y-m-d'))
            ->where('assigned_to', auth()->user()->id)
            ->orderBy('due_date', 'ASC')
            ->pluck('id')->toArray();

        $this->incompleteTasksIds = Task::incomplete()
            ->where('assigned_to', auth()->user()->id)
            ->where(function($dq) {
                return $dq->whereNull('due_date')->orWhere('due_date', '>', $this->maxSoonDate);
            })
            ->get()->pluck('id')->toArray();

        $this->upcomingDueTasksIds = Task::incomplete()
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [date('Y-m-d'), $this->maxSoonDate])
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
            ->orderBy('due_date', 'ASC')
            ->get();

        return view('livewire.project-index-dashboard')
            ->with('currentProjects', $currentProjects)
            ->with('pastDueTasks', $pastDueTasks)
            ->with('upcomingDueTasks', $upcomingDueTasks)
            ->with('incompleteTasks', $incompleteTasks);
    }
}
