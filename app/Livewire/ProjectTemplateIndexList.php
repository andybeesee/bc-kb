<?php

namespace App\Livewire;

use App\Models\ProjectTemplate;
use App\Models\ChecklistTemplate;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectTemplateIndexList extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $q = ProjectTemplate::withCount('taskGroupTemplates');

        if(!empty($this->search)) {
            $q = $q->where('name', 'LIKE', '%'.$this->search.'%');
        }

        $projectTemplates = $q->paginate(30, pageName: 'project-templates-page');

        return view('livewire.project-template-index-list')
            ->with('projectTemplates', $projectTemplates);
    }
}
