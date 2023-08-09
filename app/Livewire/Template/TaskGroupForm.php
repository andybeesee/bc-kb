<?php

namespace App\Livewire\Template;

use App\Models\TaskGroupTemplate;
use Livewire\Component;

class TaskGroupForm extends Component
{
    public string $name = '';

    public string $description = '';

    public array $tasks = [
        [ 'id' => 1, 'task' => 'One'],
        [ 'id' => 2, 'task' => 'Two'],
        [ 'id' => 3, 'task' => 'three'],
        [ 'id' => 4, 'task' => '4'],
    ];

    public bool $saveRedirect = false;

    public bool $isNew = true;

    public int $taskGroupId;

    public function render()
    {
        return view('livewire.template.task-group-form');
    }

    public function save()
    {
        $this->validate([
            'name' => [
                'required',
                'unique:task_group_templates,name'.($this->isNew ? '' : ','.$this->taskGroupId),
            ],
            'tasks' => 'array',
        ]);
        if($this->isNew) {
            $taskGroupTemplate = new TaskGroupTemplate();
        } else {
            $taskGroupTemplate = TaskGroupTemplate::findOrFail($this->taskGroupId);
        }

        $taskGroupTemplate->name = $this->name;
        $taskGroupTemplate->description = $this->description;
        $taskGroupTemplate->tasks = $this->tasks;
        $taskGroupTemplate->save();

        if($this->saveRedirect) {
            return $this->redirect(route('task-group-templates.show', $taskGroupTemplate));
        } else {
            $this->dispatch('task-group-template-saved', $taskGroupTemplate->id);
        }
    }
}
