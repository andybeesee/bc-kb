<?php

namespace App\Livewire\Kb;

use Livewire\Attributes\Url;
use Livewire\Component;

class IndexPage extends Component
{
    #[Url]
    public $tab = 'dashboard';

    public function render()
    {
        return view('livewire.kb.index-page');
    }
}
