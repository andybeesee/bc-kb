<?php

namespace App\Livewire\Template;

use App\Models\ChecklistTemplate;
use Livewire\Component;
use Livewire\WithPagination;

class ChecklistTemplateIndexList extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $q = ChecklistTemplate::query();

        $checklistTemplates =  $q->paginate(50, pageName: 'checklist-templates');

        return view('livewire.template.checklist-template-index-list')
            ->with('checklistTemplates', $checklistTemplates);
    }
}
