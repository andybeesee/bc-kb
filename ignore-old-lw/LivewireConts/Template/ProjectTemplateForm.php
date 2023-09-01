<?php

namespace ignore-old-lw\Livewire\Template-old-lw\Livewire\Template-old-lw\Livewire\Template;

use App\Models\ProjectTemplate;
use App\Models\Checklist;
use App\Models\ChecklistTemplate;
use Livewire\Component;

class ProjectTemplateForm extends Component
{
    public string $name = '';

    public string $description = '';

    public string $groupSearch = '';

    public $groups = [];

    public function render()
    {
        return view('livewire.template.project-template-form');
    }

    public function getGroupOptionsProperty()
    {
        $q = ChecklistTemplate::orderBy('name');

        if(!empty($this->groupSearch)) {
            $q = $q->where('name', 'LIKE', '%'.$this->groupSearch.'%');
        }

        if(count($this->groups) > 0) {
            $q = $q->whereNotIn('id', $this->groups);
        }

        return $q->limit(100)->get();
    }

    public function getSelectedGroupsProperty()
    {
        if(count($this->groups) === 0) {
            return [];
        }

        $sorted = [];

        $q = ChecklistTemplate::whereIn('id', $this->groups);

        if(count($this->groups) > 1) {
            $q = $q->orderByRaw('FIELD(id,'.implode(',', $this->groups).')');
        }

        return $q->get();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|unique:project_templates',
            'groups' => 'array',
            'groups.*' => 'exists:checklist_templates,id',
        ]);

        $pt = new ProjectTemplate();
        $pt->name = $this->name;
        $pt->description = $this->description;
        $pt->save();


        $idSync = [];

        foreach($this->groups as $index => $id) {
            $idSync[$id] = ['sort' => $index + 1];
        }

        $pt->checklistTemplates()->sync($idSync);

        return $this->redirect(route('project-templates.show', $pt));
    }
}
