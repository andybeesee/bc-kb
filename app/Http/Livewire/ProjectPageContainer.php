<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;

class ProjectPageContainer extends Component
{
    public $projectSearch = '';

    public $projectId = null;

    public $currentOnly = true;

    public $assignedToUser = true;

    public $teams = [];

    public $listeners = [
        'projectDetailClosed' => 'closeProject',
    ];

    protected $queryString = [
        'projectId',
    ];

    public function render()
    {
        $dashboardData = [];
        if(empty($this->projectId)) {
            $dashboardData = $this->getDashboardData();
        }

        return view('livewire.project-page-container')
            ->with('dashboardData', $dashboardData);
    }

    public function closeProject()
    {
        $this->projectId = null;
    }

    public function getProjectsProperty()
    {
        $q = Project::with('team');

        if($this->currentOnly) {
            $q->whereIn('status', [
                'planning',
                'planned',
                'in_progress',
                'late',
            ]);
        }

        if($this->assignedToUser) {
            $q = $q->where('owner_id', auth()->user()->id);
        }

        if(empty($this->projectSearch)) {
            $q = $q->where('name', 'LIKE', '%'.trim($this->projectSearch).'%');
        }

        return $q->limit(200)->get();
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
