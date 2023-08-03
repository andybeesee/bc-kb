<?php

namespace App\Livewire;

use Livewire\Component;

class TemplateIndexPage extends Component
{
    public $tab = 'project-templates';

    public string $search = '';

    public function render()
    {
        return view('livewire.template-index-page');
    }
}
