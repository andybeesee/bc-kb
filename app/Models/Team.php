<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public function members()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function boards()
    {
        return $this->morphMany(Board::class, 'owner')->orderBy('sort');
    }
}
