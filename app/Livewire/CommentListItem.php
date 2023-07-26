<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;

class CommentListItem extends Component
{
    public Comment $comment;

    public string $updatedComment;

    public bool $editing = false;

    public $rules = [
        'updatedComment' => 'required',
    ];

    public function render()
    {
        return view('livewire.comment-list-item');
    }

    public function startEditing()
    {
        $this->updatedComment = $this->comment->comment;
        $this->editing = true;
    }

    public function saveChange()
    {
        $this->validate();

        $this->comment->comment = $this->updatedComment;
        $this->comment->save();

        $this->dispatch('commentUpdated', $this->comment->id);
    }

    public function destroy()
    {
        $this->comment->delete();

        $this->dispatch('commentDeleted');
    }
}
