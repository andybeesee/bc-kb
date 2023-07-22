<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Livewire\Component;

// TODO: Complete task from dashboard, view task detail on click it
// TODO: Better dashboard...
class ProjectIndexPage extends Component
{
    public $tab = 'list';

    public $listeners = [
        'projectDetailClosed' => 'closeProject',
        'projectCreated' => 'showProject',
        'projectUpdated' => 'render',
        'status-updated' => 'render',
        'projectAdded' => 'render',
    ];

    protected $queryString = [
        'tab',
    ];

    public function mount()
    {
        $this->userId = auth()->user()->id;
    }

    public function render()
    {
        $dashboardData = $this->tab === 'dashboard' ? $this->getDashboardData() : [] ;

        return view('livewire.project-index-page')
            ->with('dashboardData', $dashboardData);
    }

    protected function getDashboardData()
    {
        $data = [];
        $data['currentProjects'] = Project::with('team')
            ->whereIn('status', [
                'planning',
                'planned',
                'in_progress',
                'late',
            ])
            ->where('owner_id', auth()->user()->id)
            ->get();

        $data['pastDueTasks'] = Task::incomplete()
            ->with('project')
            ->where('due_date', '<', date('Y-m-d'))
            ->where('assigned_to', auth()->user()->id)
            ->orderBy('due_date', 'ASC')
            ->get();

        $data['upcomingDueTasks'] = Task::incomplete()
            ->with('project')
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [
                date('Y-m-d'),
                date('Y-m-d', strtotime('+2 weeks'))
            ])
            ->orderBy('due_date', 'ASC')
            ->where('assigned_to', auth()->user()->id)
            ->get();

        $data['incompleteTasks'] = Task::incomplete()
            ->with('project')
            ->whereNull('due_date')
            ->where('assigned_to', auth()->user()->id)
            ->get();

        return $data;
    }
}
