<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Discussion;
use Livewire\Component;

class DiscussionList extends Component
{
    public $attachedId;

    public $attachedType;

    public $showDetailId = null;

    public $adding = false;

    public $newSubject = '';

    public $newDiscussionPost = '';

    public function render()
    {
        $discussions = Discussion::with(['creator', 'lastComment'])
            ->withCount(['comments'])
            ->where('attached_id', $this->attachedId)
            ->where('attached_type', $this->attachedType)
            ->orderBy('updated_at')
            ->get();

        return view('livewire.discussion-list')->with('discussions', $discussions);
    }

    public function addNewDiscussion()
    {
        $this->validate([
            'newSubject' => 'required',
            'newDiscussionPost' => 'required',
        ]);

        $discussion = new Discussion();
        $discussion->subject = $this->newSubject;
        $discussion->attached_id = $this->attachedId;
        $discussion->attached_type = $this->attachedType;
        $discussion->save();

        $c = new Comment();
        $c->comment = $this->newDiscussionPost;
        $c->attached_type = 'discussion';
        $c->attached_id = $discussion->id;
        $c->save();

        $this->adding = false;
        $this->newSubject = '';
        $this->newDiscussionPost = '';
    }
}
