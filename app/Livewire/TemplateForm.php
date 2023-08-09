<?php

namespace App\Livewire;

use App\Models\ProjectTemplate;
use App\Models\TaskGroupTemplate;
use Livewire\Component;

// TODO: Can't change type on existing
class TemplateForm extends Component
{
    public bool $saveRedirect = false;

    public string $type = 'task_group';

    public function render()
    {
        return view('livewire.template-form');
    }

}
