<?php

namespace App\Livewire\Template;

use App\Models\ChecklistTemplate;
use App\Models\ProjectTemplate;
use Livewire\Component;

class ProjectTemplateDetailPage extends Component
{
    public ProjectTemplate $projectTemplate;

    public $editing = false;

    public $updatedName;
    public $updatedDescription;

    public $newChecklistTemplate = null;

    public function mount()
    {
        $this->updatedName = $this->projectTemplate->name;
        $this->updatedDescription = $this->projectTemplate->description;
    }

    public function render()
    {
        return view('livewire.template.project-template-detail-page');
    }

    public function updateOrder(array $ids)
    {
        foreach($ids as $index => $id) {
            \DB::table('project_template_checklist_template')
                ->where('project_template_id', $this->projectTemplate->id)
                ->where('checklist_template_id', $id)
                ->update(['sort' => $index + 1]);
        }
    }

    public function getNewGroupOptionsProperty()
    {
        return ChecklistTemplate::whereNotIn('checklist_templates.id', $this->projectTemplate->checklistTemplates()->pluck('checklist_templates.id')->toArray())
            ->orderBy('checklist_templates.name')
            ->get();
    }

    public function removeChecklist($id)
    {
        \DB::table('project_template_checklist_template')
            ->where('project_template_id', $this->projectTemplate->id)
            ->where('checklist_template_id', $id)
            ->delete();
    }

    public function addChecklist()
    {
        $maxSort = \DB::table('project_template_checklist_template')
            ->where('project_template_id', $this->projectTemplate->id)
            ->max('sort') + 1;

        $this->projectTemplate->checklistTemplates()->attach($this->newChecklistTemplate, ['sort' => $maxSort]);
        $this->newChecklistTemplate = null;
    }

    public function saveChanges()
    {
        $this->projectTemplate->name = $this->updatedName;
        $this->projectTemplate->description = $this->updatedDescription;
        $this->projectTemplate->save();

        $this->editing = false;
    }
}
