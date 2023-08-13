<?php

namespace App\Livewire;

use App\Models\ProjectTemplate;
use App\Models\TaskGroupTemplate;
use Livewire\Component;

class ProjectTemplateDetailPage extends Component
{
    public ProjectTemplate $projectTemplate;

    public $editing = false;

    public $updatedName;
    public $updatedDescription;

    public $newTaskGroup = null;

    public function mount()
    {
        $this->updatedName = $this->projectTemplate->name;
        $this->updatedDescription = $this->projectTemplate->description;
    }

    public function render()
    {
        return view('livewire.project-template-detail-page');
    }

    public function updateOrder(array $ids)
    {
        foreach($ids as $index => $id) {
            \DB::table('project_template_task_group_template')
                ->where('project_template_id', $this->projectTemplate->id)
                ->where('task_group_template_id', $id)
                ->update(['sort' => $index + 1]);
        }
    }

    public function getNewGroupOptionsProperty()
    {
        return TaskGroupTemplate::whereNotIn('task_group_templates.id', $this->projectTemplate->taskGroupTemplates()->pluck('task_group_templates.id')->toArray())
            ->orderBy('task_group_templates.name')
            ->get();
    }

    public function removeTaskGroup($id)
    {
        \DB::table('project_template_task_group_template')
            ->where('project_template_id', $this->projectTemplate->id)
            ->where('task_group_template_id', $id)
            ->delete();
    }

    public function addTaskGroup()
    {
        $maxSort = \DB::table('project_template_task_group_template')
            ->where('project_template_id', $this->projectTemplate->id)
            ->max('sort') + 1;

        $this->projectTemplate->taskGroupTemplates()->attach($this->newTaskGroup, ['sort' => $maxSort]);
        $this->newTaskGroup = null;
    }

    public function saveChanges()
    {
        $this->projectTemplate->name = $this->updatedName;
        $this->projectTemplate->description = $this->updatedDescription;
        $this->projectTemplate->save();

        $this->editing = false;
    }
}
