<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Livewire\Component;

class ProjectListItem extends Component
{
    public Project $project;

    public $modifying = false;

    public $modifyTab = '';

    public function render()
    {
        return view('livewire.project-list-item');
    }

    public function openTab($name)
    {
        $this->modifyTab = $name;
        $this->modifying = true;
    }
}
