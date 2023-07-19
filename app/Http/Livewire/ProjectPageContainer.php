<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Livewire\Component;

// TODO: Complete task from dashboard, view task detail on click it
// TODO: Better dashboard...
class ProjectPageContainer extends Component
{
    public $projectSearch = '';

    public $projectId = null;

    public $currentOnly = true;

    public $assignedToUser = true;

    public $teams = [];

    public $userId = null;

    public $teamId = null;

    public $projectList = 'user';

    public $listeners = [
        'projectDetailClosed' => 'closeProject',
        'status-updated' => 'render'
    ];

    protected $queryString = [
        'projectId',
    ];

    public function mount()
    {
        $this->userId = auth()->user()->id;
    }

    public function render()
    {
        $dashboardData = [];
        if(empty($this->projectId)) {
            $dashboardData = $this->getDashboardData();
        }

        $allTeams = Team::orderBy('name')->get();

        $userTeams = Team::orderBy('name')
            ->whereHas('members', fn($mq) => $mq->where('users.id', auth()->user()->id))
            ->get();

        $usersOnYourTeams = User::orderBy('name')
            ->whereHas('teams', fn($tq) => $tq->whereIn('team_id', $userTeams->pluck('id')->toArray()))
            ->get();

        $allUsers = User::orderBy('name')->get();

        return view('livewire.project-page-container')
            ->with('dashboardData', $dashboardData)
            ->with('allTeams', $allTeams)
            ->with('userTeams', $userTeams)
            ->with('usersOnYourTeams', $usersOnYourTeams)
            ->with('allUsers', $allUsers);
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

        switch ($this->projectList) {
            case 'user':
                $q = $q->where('owner_id', $this->userId ?? auth()->user()->id);
                break;
            case 'team':
                if(empty($this->teamId)) {
                    $q = $q->whereHas('team', function($tq) {
                        return $tq->whereHas('members', fn($mq) => $mq->where('team_user.user_id', auth()->user()->id));
                    });
                } else {
                    $q = $q->where('team_id', $this->teamId);
                }
                break;
        }

        if(empty($this->projectSearch)) {
            $q = $q->where('name', 'LIKE', '%'.trim($this->projectSearch).'%');
        }

        return $q->limit(200)->get();
    }

    public function showUserProjects($userId)
    {
        $this->projectList = 'user';
        $this->teamId = null;
        $this->userId = $userId;
    }

    public function showTeamProjects($teamId)
    {
        $this->projectList = 'team';
        $this->teamId = $teamId;
        $this->userId = null;
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
