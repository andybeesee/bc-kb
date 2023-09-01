<?php

namespace ignore-old-lw\Livewire-old-lw\Livewire-old-lw\Livewire;

use App\Models\Project;
use App\Models\ProjectTemplate;
use Livewire\Component;
use Livewire\Attributes\Url;

class ProjectForm extends Component
{
    public null|Project $project = null;

    public string $status = 'idea';

    public int|null $teamId = null;

    public int|null $ownerId = null;

    public string $name = '';

    public string $description = '';

    public string $dueDate = '';

    public $highlightTemplate = false;

    public $isNew = false;

    #[Url]
    public $template = null;

    public function mount()
    {
        if(!empty($this->template)) {
            $this->highlightTemplate = true;
        }

        if(empty($this->project)) {
            $this->isNew = true;
            $this->status = 'idea';
            $this->teamId = auth()->user()->teams()->first()?->id;
            $this->ownerId = auth()->user()->id;
        } else {
            $this->name = $this->project->name;
            $this->status = $this->project->status;
            $this->teamId = $this->project->team_id;
            $this->ownerId = $this->project->owner_id;
            $this->dueDate = $this->project->due_date ? $this->project->due_date->format('Y-m-d') : '';
        }
    }

    public $rules = [

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
            'name' => 'required|unique:projects,name'.($this->isNew ? '' : ','.$this->project->id),
            // 'name' => 'required',
            'description' => 'nullable',
            'dueDate' => 'nullable|date',
            'status' => 'required',
            'teamId' => 'nullable|exists:teams,id',
            'ownerId' => 'nullable|exists:users,id',
        ]);

        if($this->isNew) {
            $this->project = new Project();
        }

        $this->project->name = $this->name;
        $this->project->status = $this->status;
        $this->project->team_id = $this->teamId;
        $this->project->owner_id = $this->ownerId;
        $this->project->due_date = empty($this->dueDate) ? null : $this->dueDate;
        $this->project->save();

        if($this->isNew) {
            if(!empty($this->template)) {
                $this->project->importProjectTemplate($this->template);
            }

            $this->dispatch('project-created', $this->project->id);

        } else {
            $this->dispatch('project-updated', $this->project->id);
        }
    }

    public function getTemplateOptionsProperty()
    {
        return ProjectTemplate::orderBy('name')->get();
    }
}
