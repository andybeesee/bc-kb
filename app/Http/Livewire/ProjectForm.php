<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Livewire\Component;

class ProjectForm extends Component
{
    public null|Project $project = null;

    public $isNew = false;

    public function mount()
    {
        if(empty($this->project)) {
            $this->isNew = true;
            $this->project = new \App\Models\Project();
            $this->project->team_id = auth()->user()->teams()->first()?->id;
            $this->project->owner_id = auth()->user()->id;
        }
    }

    public function render()
    {
        $teams = \App\Models\Team::orderBy('name')->get();
        $owners = \App\Models\User::orderBy('name')->get();
        $statuses = config('statuses');

        return view('livewire.project-form')
            ->with('teams', $teams)
            ->with('owners', $owners)
            ->with('statuses', $statuses);
    }
}
