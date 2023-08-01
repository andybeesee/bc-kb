<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
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

    public function render()
    {
        \Log::debug("RENDER HITS?", [$this->attachedId, $this->attachedType]);

        $comments = Comment::with('creator')
            ->orderBy('created_at', 'DESC')
            ->where('attached_id', $this->attachedId)
            ->where('attached_type', $this->attachedType)
            ->get();

        \Log::debug("COMMENT COUNT IS ".$comments->count());

        return view('livewire.comment-list', ['comments' => $comments]);
    }

    #[On('commentUpdated')]
    public function handleCommentUpdated()
    {
        \Log::debug('handle update');
    }

    #[On('commentDeleted')]
    public function handleCommentDeleted()
    {
        \Log::debug('handle update');
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
        \Log::debug("NEW COMMENT ADDED");
    }

    public function saveChange($commentId, $updatedComment)
    {
        \DB::table('comments')
            ->where('id', $commentId)
            ->update([
                'comment' => $updatedComment,
                'updated_at' => now(),
                'updated_by' => auth()->user()->id,
            ]);
    }

    public function destroyComment($commentId)
    {
        \DB::table('comments')
            ->where('id', $commentId)
            ->delete();
    }
}
