<?php

namespace App\Livewire;

use App\Models\TaskGroupTemplate;
use Livewire\Component;
use Livewire\WithPagination;

class TaskGroupTemplateIndexList extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $q = TaskGroupTemplate::query();

        $taskGroupTemplates =  $q->paginate(50, pageName: 'task-group-templates');

        return view('livewire.task-group-template-index-list')
            ->with('taskGroupTemplates', $taskGroupTemplates);
    }
}
