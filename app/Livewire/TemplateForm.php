<?php

namespace App\Livewire;

use App\Models\ProjectTemplate;
use App\Models\TaskGroupTemplate;
use App\Models\Template;
use Livewire\Component;

class TemplateForm extends Component
{
    public bool $saveRedirect = false;

    public null|Template $template = null;

    public string $type = 'project';

    public string $name = '';

    public string $description = '';

    public array $tasks = [
        ['id' => 1, 'task' => 'Task One'],
        ['id' => 2, 'task' => 'Task Two'],
        ['id' => 3, 'task' => 'Task Three'],

    ];

    public function mount()
    {
        if(!empty($this->template)) {
            $this->name = $this->template->name;
            $this->description = $this->template->description;
            $this->tasks = $this->template->tasks;
            $this->type = $this->template->type;
        }
    }

    public function render()
    {
        return view('livewire.template-form');
    }

    public function saveTemplate()
    {
        if($this->saveRedirect) {
            \Log::debug("redirect");
        } else {
            $this->dispatch('templateCreated');
        }
    }
}
