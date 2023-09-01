<?php

namespace ignore-old-lw\Livewire-old-lw\Livewire-old-lw\Livewire;

use App\Models\Discussion;
use Livewire\Component;

class DiscussionDetail extends Component
{
    public Discussion $discussion;

    public function render()
    {
        return view('livewire.discussion-detail');
    }
}
