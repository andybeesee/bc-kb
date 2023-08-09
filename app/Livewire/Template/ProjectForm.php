<?php

namespace App\Livewire\Template;

use App\Models\TaskGroupTemplate;
use Livewire\Component;

class ProjectForm extends Component
{
    public string $name = '';

    public string $description = '';

    public $groups = [];

    public function render()
    {
        $groupOptions = TaskGroupTemplate::orderBy('name')->get();

        return view('livewire.template.project-form')->with('groupOptions', $groupOptions);
    }
}
