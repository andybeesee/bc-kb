<?php

namespace ignore-old-lw\Livewire-old-lw\Livewire-old-lw\Livewire;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Attributes\On;
// TODO: I want to show more here... with option to change project due date, status right here...
class ProjectIndexList extends Component
{
    #[Url]
    public bool $filtersOpen = false;

    #[Url]
    public string $filterType = 'current_user';

    #[Url]
    public int|null|string $filterId = null;

    public string $projectSearch = '';

    #[Url]
    public array $statusesToShow = [
        'planning',
        'planned',
        'in_progress',
        'late',
    ];

    public int|null $updateForm = null;

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

    #[On('project-updated')]
    public function closeProjectUpdateForm()
    {
        $this->updateForm = null;
    }

    #[Computed]
    public function projects()
    {
        $q = Project::with(['team', 'owner', 'currentStatus', 'currentStatus.creator'])
            ->withCount(['pastDueTasks', 'incompleteTasks']);


        if(!empty($this->projectSearch)) {
            // TODO: More thorough searching
            $q = $q->where('name', 'LIKE', '%'.trim($this->projectSearch).'%');
        } else {
            //searching removes the filter
            if(count($this->statusesToShow) > 0) {
                $q->whereIn('status', $this->statusesToShow);
            }

            switch ($this->filterType) {
                case 'current_user':
                    $q = $q->where('owner_id', auth()->user()->id);
                    break;
                case 'current_user_teams':
                    $q = $q->whereHas('team', function($tq) {
                        return $tq->whereHas('members', fn($mq) => $mq->where('team_user.user_id', auth()->user()->id));
                    });
                    break;
                case 'all_user':
                case 'team_user':
                    $q = $q->where('owner_id', $this->filterId);
                    break;
                case 'all_team':
                case 'user_team':
                    $q = $q->where('team_id', $this->filterId);
                    break;
            }
        }


        return $q->limit(200)->get();
    }
}
