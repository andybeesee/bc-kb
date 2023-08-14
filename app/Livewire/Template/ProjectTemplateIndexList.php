<?php

namespace App\Livewire\Template;

use App\Models\ProjectTemplate;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectTemplateIndexList extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $q = ProjectTemplate::withCount('checklistTemplates');

        if(!empty($this->search)) {
            $q = $q->where('name', 'LIKE', '%'.$this->search.'%');
        }

        $projectTemplates = $q->paginate(30, pageName: 'project-templates-page');

        return view('livewire.template.project-template-index-list')
            ->with('projectTemplates', $projectTemplates);
    }
}
