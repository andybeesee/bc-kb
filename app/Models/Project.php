<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    const CLOSED_PROJECT_STATUSES = [
        'complete',
        'abandoned',
    ];

    const IN_PROGRESS_PROJECT_STATUSES = [
        'planning',
        'planned',
        'in_progress',
        'late',
    ];


    protected $casts = [
        'due_date' => 'date',
        'completed_date' => 'date',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function boards()
    {
        return $this->hasMany(Board::class)
            ->orderBy('boards.sort')
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
