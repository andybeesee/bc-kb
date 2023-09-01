<?php

namespace ignore-old-lw\Livewire-old-lw\Livewire-old-lw\Livewire;

use App\Models\Project;
use Livewire\Component;

class ProjectDashboard extends Component
{
    public Project $project;

    public function render()
    {
        return view('livewire.project-dashboard');
    }
}
