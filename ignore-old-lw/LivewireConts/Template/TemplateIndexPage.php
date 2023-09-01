<?php

namespace ignore-old-lw\Livewire\Template-old-lw\Livewire\Template-old-lw\Livewire\Template;

use Livewire\Component;
use Livewire\Features\SupportQueryString\Url;
use Livewire\WithPagination;

class TemplateIndexPage extends Component
{
    use WithPagination;

    #[Url]
    public $tab = 'project-templates';

    public $newType = 'project';

    public function render()
    {
        return view('livewire.template.template-index-page');
    }
}
