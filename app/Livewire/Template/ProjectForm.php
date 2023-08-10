<?php

namespace App\Livewire\Template;

use App\Models\ProjectTemplate;
use App\Models\TaskGroup;
use App\Models\TaskGroupTemplate;
use Livewire\Component;

class ProjectForm extends Component
{
    public string $name = '';

    public string $description = '';

    public string $groupSearch = '';

    public $groups = [];

    public function render()
    {
        return view('livewire.template.project-form');
    }

    public function getGroupOptionsProperty()
    {
        $q = TaskGroupTemplate::orderBy('name');

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

        return TaskGroupTemplate::whereIn('id', $this->groups)->orderBy('name')->get();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|unique:project_templates',
            'groups' => 'array',
            'groups.*' => 'exists:task_group_templates,id',
        ]);

        $pt = new ProjectTemplate();
        $pt->name = $this->name;
        $pt->description = $this->description;
        $pt->save();

        $pt->taskGroupTemplates()->sync($this->groups);

        return $this->redirect(route('project-templates.show', $pt));
    }
}
