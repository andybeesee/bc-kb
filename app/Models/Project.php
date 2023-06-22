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

    public function scopeForUser($q, $user)
    {
        $user = $user instanceof User ? $user->id : $user;

        return $q->whereHas('boards', function($bq) use($user) {
            return $bq->whereHas('tasks', function($tq) use($user) {
                return $tq->where('assigned_to', $user);
            });
        });
    }
}
