<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function boards()
    {
        return $this->belongsToMany(Board::class)
            ->orderBy('board_project.sort')
            ->orderBy('boards.name');
    }
}
