<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;

class CommentListItem extends Component
{
    public Comment $comment;

    public bool $editing = false;

    public function render()
    {
        return view('livewire.comment-list-item');
    }
}
