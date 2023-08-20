<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('sort');
    }

    public static function getNextTaskSort($projectId, $checklistId = null)
    {
        $sortQuery = \Illuminate\Support\Facades\DB::table('tasks')
            ->where('project_id', $projectId);

        if(empty($checklistId)) {
            $sortQuery = $sortQuery->whereNull('checklist_id');
        } else {
            $sortQuery = $sortQuery->where('checklist_id', $checklistId);
        }

        return $sortQuery->max('sort') + 1;
    }
}
