<?php

namespace App\Livewire;

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
            $this->project->status = 'idea';
            $this->project->team_id = auth()->user()->teams()->first()?->id;
            $this->project->owner_id = auth()->user()->id;
        }
    }

    public $rules = [
        'project.name' => 'required',
        'project.description' => 'nullable',
        'project.due_date' => 'nullable|date',
        'project.status' => 'required',
        'project.team_id' => 'nullable|exists:teams,id',
        'project.owner_id' => 'nullable|exists:users,id',
    ];

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

    public function saveProject()
    {
        $this->validate([
            'project.name' => 'unique:projects,name'.($this->isNew ? '' : ','.$this->project->id),
        ]);

        $this->project->save();

        if($this->isNew) {
            $this->dispatch('projectCreated', $this->project->id);
        } else {
            $this->dispatch('projectUpdated', $this->project->id);
        }
    }
}
