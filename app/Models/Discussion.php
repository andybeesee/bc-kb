<?php

namespace App\Models;

use App\Traits\TracksCreatorUpdater;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory, TracksCreatorUpdater;

    public function comments()
    {
        return $this->morphMany(Comment::class, 'attached');
    }

    public function lastComment()
    {
        return $this->morphOne(Comment::class, 'attached')->orderBy('created_at', 'DESC');
    }

    public function attached()
    {
        return $this->morphTo('attached');
    }
}
