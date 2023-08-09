<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Features\SupportQueryString\Url;

class TemplateIndexPage extends Component
{
    #[Url]
    public $tab = 'templates';

    public $newType = 'project';

    public string $search = '';

    public function render()
    {
        return view('livewire.template-index-page');
    }
}
