<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistTemplate extends Model
{
    use HasFactory;

    protected $casts = [
        'tasks' => 'array',
    ];

    public function projectTemplates()
    {
        return $this->belongsToMany(ProjectTemplate::class, 'project_template_checklist_template');
    }
}
