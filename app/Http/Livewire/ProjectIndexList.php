<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Livewire\Component;

class ProjectIndexList extends Component
{
    public bool $filtersOpen = false;

    public string $filterType = 'current_user';

    public int|null $filterId = null;

    public string $projectSearch = '';

    public array $statusesToShow = [
        'planning',
        'planned',
        'in_progress',
        'late',
    ];

    protected $queryString = [
        'statusesToShow',
        'filterType',
        'filterId',
        'filtersOpen',
    ];

    public function render()
    {
        $allTeams = collect([]);
        $userTeams = collect([]);
        $usersOnYourTeams = collect([]);
        $allUsers = collect([]);

        if($this->filtersOpen) {
            $allTeams = Team::orderBy('name')->get();

            $userTeams = Team::orderBy('name')
                ->whereHas('members', fn($mq) => $mq->where('users.id', auth()->user()->id))
                ->get();

            $usersOnYourTeams = User::orderBy('name')
                ->whereHas('teams', fn($tq) => $tq->whereIn('team_id', $userTeams->pluck('id')->toArray()))
                ->get();

            $allUsers = User::orderBy('name')->get();
        }

        return view('livewire.project-index-list')
            ->with('statusOptions', config('statuses'))
            ->with('allTeams', $allTeams)
            ->with('userTeams', $userTeams)
            ->with('usersOnYourTeams', $usersOnYourTeams)
            ->with('allUsers', $allUsers);
    }

    public function setFilter($type, $id = null)
    {
        $this->filterId = $id;
        $this->filterType = $type;
    }

    public function getProjectsProperty()
    {
        $q = Project::with(['team', 'owner'])
            ->withCount(['pastDueTasks', 'incompleteTasks']);

        $q = $q->where(function($pq) {
            if(count($this->statusesToShow) > 0) {
                $pq->whereIn('status', $this->statusesToShow);
            }

            switch ($this->filterType) {
                case 'current_user':
                    $pq = $pq->where('owner_id', auth()->user()->id);
                    break;
                case 'current_user_teams':
                    $pq = $pq->whereHas('team', function($tq) {
                        return $tq->whereHas('members', fn($mq) => $mq->where('team_user.user_id', auth()->user()->id));
                    });
                    break;
                case 'all_user':
                case 'team_user':
                    $pq = $pq->where('owner_id', $this->filterId);
                    break;
                case 'all_team':
                case 'user_team':
                    $pq = $pq->where('team_id', $this->filterId);
                    break;
            }

            if(empty($this->projectSearch)) {
                $pq = $pq->where('name', 'LIKE', '%'.trim($this->projectSearch).'%');
            }

            return $pq;
        });

        return $q->limit(200)->get();
    }
}
