<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Livewire\Component;

class ProjectDetailPage extends Component
{
    public int $projectId;

    public function render()
    {
        $project = Project::findOrFail($this->projectId);

        return view('livewire.project-detail-page')->with('project', $project);
    }
}
