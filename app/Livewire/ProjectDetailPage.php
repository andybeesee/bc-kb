<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;

class ProjectDetailPage extends Component
{
    public Project $project;

    protected $listeners = [
        'setProjectDueDate' => 'setDueDate',
        'removeProjectDueDate' => 'removeDueDate',
        'projectUpdated' => 'handleProjectUpdate'
    ];

    public string $tab = 'dashboard';

    protected $queryString = [
        'tab',
    ];

    public function render()
    {
        // $project = Project::findOrFail($this->project->id);

        return view('livewire.project-detail-page');
    }

    public function setDueDate($date)
    {
        $this->project->due_date = $date;
        $this->project->save();
    }

    public function removeDueDate()
    {
        $this->project->due_date = null;
        $this->project->save();
    }

    public function handleProjectUpdate()
    {
        $this->tab = 'dashboard';
    }
}
