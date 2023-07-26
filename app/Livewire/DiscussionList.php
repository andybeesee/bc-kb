<?php

namespace App\Livewire;

use App\Models\Discussion;
use Livewire\Component;

class DiscussionList extends Component
{
    public $attachedId;

    public $attachedType;

    public $showDetailId = null;

    public function render()
    {
        // TODO: does clicking on it show detail in place of list? or do we go to a different page?

        $discussions = Discussion::with(['creator'])
            ->withCount(['comments'])
            ->where('attached_id', $this->attachedId)
            ->where('attached_type', $this->attachedType)
            ->orderBy('updated_at')
            ->get();

        return view('livewire.discussion-list')->with('discussions', $discussions);
    }
}
