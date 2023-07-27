<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CommentList extends Component
{
    public string $attachedType;

    public int $attachedId;

    public bool $adding = false;

    public string $newComment = '';

    public $rules = [
        'newComment' => 'required'
    ];

    protected $listeners = [
        'commentUpdated' => 'render',
        'commentDeleted' => 'render',
    ];

    public function render()
    {
        \Log::debug("RENDER HITS?", [$this->attachedId, $this->attachedType]);
        // TODO: Paginate?
        return view('livewire.comment-list');
    }

    public function addComment()
    {
        $this->validate();

        $comment = new Comment();
        $comment->comment = $this->newComment;
        $comment->attached_id = $this->attachedId;;
        $comment->attached_type = $this->attachedType;
        $comment->save();

        $this->newComment = '';
    }

    #[Computed]
    public function comments()
    {
        return Comment::with('creator')
             ->orderBy('created_at', 'DESC')
             ->where('attached_id', $this->attachedId)
             ->where('attached_type', $this->attachedType)
             ->get();
    }
}
