<?php

namespace ignore-old-lw\Livewire-old-lw\Livewire-old-lw\Livewire;

use App\Models\Project;
use Livewire\Component;

class ProjectUpdateStatusForm extends Component
{
    public int $projectId;

    public string $newStatusDescription = '';

    public null|string $newStatus = '';

    public Project $project;

    public function mount()
    {
        $this->project = Project::with('currentStatus')->findOrFail($this->projectId);
        $this->newStatus = $this->project->status;
    }

    public function render()
    {
        $statusOptions = config('statuses');

        return view('livewire.project-update-status-form')
            ->with('statusOptions', $statusOptions);
    }

    public function updateThatStatus()
    {
        if(!empty($this->newStatusDescription)) {
            $this->project->setStatus($this->newStatusDescription);
        }

        if($this->newStatus !== $this->project->status) {
            $this->project->status = $this->newStatus;
            $this->project->save();
        }

        $this->newStatusDescription = '';

        $this->dispatch('project-updated', $this->project->id);
    }
}
