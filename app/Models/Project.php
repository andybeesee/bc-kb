<?php

namespace App\Models;

use App\Traits\HasStatuses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    use HasFactory, HasStatuses;

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

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function incompleteTasks()
    {
        return $this->tasks()->whereNull('completed_date');
    }

    public function pastDueTasks()
    {
        return $this->incompleteTasks()->whereNotNull('due_date')->where('due_date', '<', date('Y-m-d'));
    }

    public function tasksAssignedToUser($userId = null)
    {
        $userId = $userId ?? auth()->user()->id;

        return $this->tasks()->where('assigned_to', $userId);
    }

    public function incompleteUserTasks($userId = null)
    {
        return $this->tasksAssignedToUser($userId)->whereNull('completed_date');
    }

    public function scopeAddTaskCounts($q)
    {
        return $q->withCount(['pastDueTasks', 'incompleteTasks', 'incompleteUserTasks']);
    }

    public function scopeWithOpenTasks($q)
    {
        return $q->whereHas('incompleteTasks');
    }

    public function boards()
    {
        return $this->belongsToMany(Board::class);
    }

    public function scopeForUser($q, $user)
    {
        $user = $user instanceof User ? $user->id : $user;

        return $q->whereHas('tasks', function($tq) use($user) {
            return $tq->where('assigned_to', $user);
        });
    }

    public function getIsCompleteAttribute()
    {
        return !empty($this->completed_date);
    }

    public function getIsLateAttribute()
    {
        if(empty($this->due_date)) {
            return false;
        }

        return $this->due_date->isPast();
    }

    public function importProjectTemplate($templateId)
    {
        ProjectTemplate::with('checklistTemplates')
            ->where('id', $templateId)
            ->first()
            ->checklistTemplates
            ->each(function(ChecklistTemplate $tgt, $index) {
                $this->importChecklistTemplate($tgt, $tgt->pivot->sort);
            });
    }

    public function importChecklistTemplate(ChecklistTemplate $tgt, $sort = null)
    {
        if(is_null($sort)) {
            $sort = DB::table('checklists')->where('project_id', $this->id)->max('sort') + 1;
        }

        $tg = new Checklist();
        $tg->name = $tgt->name;
        $tg->description = $tgt;
        $tg->project_id = $this->id;
        $tg->sort = $sort;
        $tg->save();

        foreach($tgt->tasks as $index => $taskTemplate) {
            $task = new Task();
            $task->name = $taskTemplate['task'];
            $task->project_id = $this->id;
            $task->checklist_id = $tg->id;
            $task->sort = $index + 1;
            $task->save();
        }
    }

    public function copyFrom($projectId, $checklistId)
    {
        $sort = Checklist::getNextTaskSort($this->proejctId);

        $taskQuery = \App\Models\Task::where('project_id', $projectId);

        if(is_null($checklistId) || $checklistId === 'default') {
            $taskQuery->whereNull('checklist_id');
            $newChecklistId = null;
        } else {
            $projSort = static::getNextChecklistSort($this->projectId);

            $taskQuery->where('checklist_id', $checklistId);

            $fromCl = Checklist::findOrFail($checklistId);

            $cl = new Checklist();
            $cl->name = $fromCl->name;
            $cl->project_id = $this->id;
            $cl->sort = $projSort;
            $cl->save();

            $newChecklistId = $cl->id;
        }

        $toInsert = $taskQuery->get()
            ->map(function($t, $index) use($sort, $newChecklistId) {
                return [
                    'project_id' => $this->id,
                    'checklist_id' => $newChecklistId,
                    'name' => $t->name,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'sort' => $index + $sort,
                ];
            })->toArray();

        \Illuminate\Support\Facades\DB::table('tasks')->insert($toInsert);
    }

    public static function getNextChecklistSort($projectId)
    {
        return \Illuminate\Support\Facades\DB::table('checklists')
                ->where('project_id', $projectId)
                ->max('sort') + 1;
    }
}
