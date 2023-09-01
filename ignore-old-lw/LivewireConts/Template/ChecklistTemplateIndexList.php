<?php

namespace ignore-old-lw\Livewire\Template-old-lw\Livewire\Template-old-lw\Livewire\Template;

use App\Models\ChecklistTemplate;
use Livewire\Component;
use Livewire\WithPagination;

class ChecklistTemplateIndexList extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $q = ChecklistTemplate::orderBy('name');

        if(!empty($this->search)) {
            $q = $q->where('name', 'LIKE', '%'.$this->search.'%');
        }

        $checklistTemplates =  $q->paginate(50, pageName: 'checklist-templates');

        return view('livewire.template.checklist-template-index-list')
            ->with('checklistTemplates', $checklistTemplates);
    }
}
