<?php

namespace App\Livewire;

use App\Models\ProjectTemplate;
use Livewire\Component;

class ProjectTemplateDetailPage extends Component
{
    public ProjectTemplate $projectTemplate;

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

    public function addTaskGroup()
    {

    }

    public function saveChanges()
    {

    }
}
