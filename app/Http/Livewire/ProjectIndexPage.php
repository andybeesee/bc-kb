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
    public $projectSearch = '';

    public $currentOnly = true;

    public $assignedToUser = true;

    public $tab = 'list';

    public $teams = [];

    public $userId = null;

    public $teamId = null;

    public $projectList = 'user';

    public bool $newProject = false;

    public array $statusesToShow = [
        'planning',
        'planned',
        'in_progress',
        'late',
    ];

    public $listeners = [
        'projectDetailClosed' => 'closeProject',
        'projectCreated' => 'showProject',
        'projectUpdated' => 'render',
        'status-updated' => 'render',
        'projectAdded' => 'render',
    ];

    protected $queryString = [
        'newProject',
        'teamId',
        'projectList',
        'statusesToShow',
    ];

    public function mount()
    {
        $this->userId = auth()->user()->id;
    }

    public function render()
    {
        $dashboardData = $this->tab === 'dashboard' ? $this->getDashboardData() : [] ;

        $allTeams = Team::orderBy('name')->get();

        $userTeams = Team::orderBy('name')
            ->whereHas('members', fn($mq) => $mq->where('users.id', auth()->user()->id))
            ->get();

        $usersOnYourTeams = User::orderBy('name')
            ->whereHas('teams', fn($tq) => $tq->whereIn('team_id', $userTeams->pluck('id')->toArray()))
            ->get();

        $allUsers = User::orderBy('name')->get();

        $statusOptions = config('statuses');

        return view('livewire.project-index-page')
            ->with('dashboardData', $dashboardData)
            ->with('statusOptions', $statusOptions)
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
        $q = Project::with(['team', 'owner'])
            ->withCount(['pastDueTasks', 'incompleteTasks']);

        $q = $q->where(function($pq) {
            if(count($this->statusesToShow) > 0) {
                $pq->whereIn('status', $this->statusesToShow);
            }

            switch ($this->projectList) {
                case 'user':
                    $pq = $pq->where('owner_id', $this->userId ?? auth()->user()->id);
                    break;
                case 'team':
                    if(empty($this->teamId)) {
                        $pq = $pq->whereHas('team', function($tq) {
                            return $tq->whereHas('members', fn($mq) => $mq->where('team_user.user_id', auth()->user()->id));
                        });
                    } else {
                        $pq = $pq->where('team_id', $this->teamId);
                    }
                    break;
            }

            if(empty($this->projectSearch)) {
                $pq = $pq->where('name', 'LIKE', '%'.trim($this->projectSearch).'%');
            }

            return $pq;
        });

        if(!empty($this->projectId)) {
            $q = $q->orWhere('id', $this->projectId);
        }

        return $q->limit(200)->get();
    }

    public function openNewProjectForm()
    {
        $this->newProject = true;
        $this->projectId = null;
    }

    public function showUserProjects($userId)
    {
        $this->newProject = false;
        $this->projectList = 'user';
        $this->teamId = null;
        $this->userId = $userId;
    }

    public function showTeamProjects($teamId)
    {
        $this->newProject = false;
        $this->projectList = 'team';
        $this->teamId = $teamId;
        $this->userId = null;
    }

    public function showDashboard()
    {
        $this->newProject = false;
        $this->projectId = null;
    }

    public function showProject($projectId)
    {
        $this->newProject = false;
        $this->projectId = $projectId;
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
