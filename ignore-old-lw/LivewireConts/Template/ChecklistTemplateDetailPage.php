<?php

namespace ignore-old-lw\Livewire\Template-old-lw\Livewire\Template-old-lw\Livewire\Template;

use App\Models\ChecklistTemplate;
use Livewire\Component;

class ChecklistTemplateDetailPage extends Component
{
    public ChecklistTemplate $checklistTemplate;

    public $editing = false;

    public $updatedName = '';

    public $updatedDescription = '';

    public $tasks = [];

    public function mount()
    {
        $this->tasks = $this->checklistTemplate->tasks;
        $this->updatedName = $this->checklistTemplate->name;
        $this->updatedDescription = $this->checklistTemplate->description;
    }

    public function render()
    {
        return view('livewire.template.checklist-template-detail-page');
    }

    public function saveChanges()
    {
        $this->checklistTemplate->name = $this->updatedName;
        $this->checklistTemplate->description = $this->updatedDescription;
        $this->checklistTemplate->save();

        $this->editing = false;
    }

    public function updatedTasks()
    {
        $this->checklistTemplate->tasks = $this->tasks;
        $this->checklistTemplate->save();
    }

}
