<?php

namespace App\Http\Livewire;

use App\Models\Project;
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
        return view('livewire.project-page-container');
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
}
