<?php

namespace App\Livewire;

use App\Models\ProjectTemplate;
use Livewire\Component;

class ProjectTemplateDetailPage extends Component
{
    public ProjectTemplate $projectTemplate;

    public function render()
    {
        return view('livewire.project-template-detail-page');
    }
}
