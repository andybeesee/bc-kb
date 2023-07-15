<?php

namespace App\Http\Livewire;

use App\Models\Comment;
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
        // TODO: Paginate?
        $comments = Comment::with('creator')
            ->orderBy('created_at', 'DESC')
            ->where('attached_id', $this->attachedId)
            ->where('attached_type', $this->attachedType)
            ->get();

        return view('livewire.comment-list')->with('comments', $comments);
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
}
