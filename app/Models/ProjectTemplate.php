<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTemplate extends Model
{
    use HasFactory;

    public function checklistTemplates()
    {
        return $this->belongsToMany(ChecklistTemplate::class, 'project_template_checklist_template')
            ->withPivot('sort')
            ->orderBy('project_template_checklist_template.sort');
    }
}
