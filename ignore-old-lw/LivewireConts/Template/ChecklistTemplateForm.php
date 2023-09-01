<?php

namespace ignore-old-lw\Livewire\Template-old-lw\Livewire\Template-old-lw\Livewire\Template;

use App\Models\ChecklistTemplate;
use Livewire\Component;

class ChecklistTemplateForm extends Component
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

    public int $checklistId;

    public function render()
    {
        return view('livewire.template.checklist-template-form');
    }

    public function save()
    {
        $this->validate([
            'name' => [
                'required',
                'unique:checklist_templates,name'.($this->isNew ? '' : ','.$this->checklistId),
            ],
            'tasks' => 'array',
        ]);
        if($this->isNew) {
            $checklistTemplate = new ChecklistTemplate();
        } else {
            $checklistTemplate = ChecklistTemplate::findOrFail($this->checklistId);
        }

        $checklistTemplate->name = $this->name;
        $checklistTemplate->description = $this->description;
        $checklistTemplate->tasks = $this->tasks;
        $checklistTemplate->save();

        if($this->saveRedirect) {
            return $this->redirect(route('task-group-templates.show', $checklistTemplate));
        } else {
            $this->dispatch('task-group-template-saved', $checklistTemplate->id);
        }
    }
}
