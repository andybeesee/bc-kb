<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Attributes\Url;
use Livewire\Component;

class ProjectDetailPage extends Component
{
    public Project $project;

    protected $listeners = [
        'setProjectDueDate' => 'setDueDate',
        'removeProjectDueDate' => 'removeDueDate',
        'projectUpdated' => 'handleProjectUpdate'
    ];

    #[Url]
    public string $tab = 'dashboard';

    public function render()
    {
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
