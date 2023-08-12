<?php

namespace App\Livewire;

use App\Models\ProjectTemplate;
use App\Models\TaskGroupTemplate;
use Livewire\Component;
use Livewire\Features\SupportQueryString\Url;
use Livewire\WithPagination;

class TemplateIndexPage extends Component
{
    use WithPagination;

    #[Url]
    public $tab = 'task-group-templates';

    public $newType = 'project';

    public function render()
    {
        return view('livewire.template-index-page');
    }
}
