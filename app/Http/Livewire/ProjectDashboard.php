<?php

namespace App\Http\Livewire;

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
