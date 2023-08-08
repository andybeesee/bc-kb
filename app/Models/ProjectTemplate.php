<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTemplate extends Model
{
    use HasFactory;

    public function taskGroupTemplates()
    {
        return $this->belongsToMany(TaskGroupTemplate::class);
    }
}
