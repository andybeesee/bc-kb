<?php

namespace ignore-old-lw\Livewire-old-lw\Livewire-old-lw\Livewire;

use App\Models\Project;
use App\Models\Task;
use App\Traits\LivewireProjectFunctions;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Attributes\On;
// TODO: Complete task from dashboard, view task detail on click it
// TODO: Better dashboard...
class ProjectIndexPage extends Component
{
    use LivewireProjectFunctions;

    #[Url]
    public $tab = 'dashboard';

    public function mount()
    {
        $this->userId = auth()->user()->id;
    }

    public function render()
    {
        return view('livewire.project-index-page');
    }

    #[On('project-updated')]
    public function handleProjectUpdate()
    {
        // TODO: probably something
    }

    #[On('project-created')]
    public function showProject($projectId)
    {
        $this->redirect(route('projects.show', $projectId));
    }
}
