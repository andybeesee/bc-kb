<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $casts = [
        'due_date' => 'date',
        'completed_date' => 'date',
    ];

    public function user()
    {
        return $this->morphTo(User::class, 'owner');
    }

    public function team()
    {
        return $this->morphTo(Team::class, 'owner');
    }
}
