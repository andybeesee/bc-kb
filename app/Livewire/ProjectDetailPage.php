<?php

namespace App\Livewire;

use App\Models\Project;
use App\Traits\LivewireProjectFunctions;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class ProjectDetailPage extends Component
{
    use LivewireProjectFunctions;

    public Project $project;

    #[Url]
    public string $tab = 'dashboard';

    public function render()
    {
        return view('livewire.project-detail-page');
    }

    #[On('project-updated')]
    public function handleProjectUpdate($projectId)
    {
        if($projectId === $this->project->id) {
            $this->tab = 'dashboard';
            $this->project = $this->project->refresh();
        }

    }

}
