<?php

namespace App\Traits;

use App\Models\File;
use Illuminate\Support\Facades\DB;
use Livewire\TemporaryUploadedFile;

trait LivewireTaskFunctions
{

    public function handleSetTaskDue($taskId, $date)
    {
        DB::table('tasks')
            ->where('id', $taskId)
            ->update(['due_date' => $date, 'updated_at' => now()]);
    }

    public function handleRemoveTaskDue($taskId)
    {
        DB::table('tasks')
            ->where('id', $taskId)
            ->update(['due_date' => null, 'updated_at' => now()]);
    }

    public function storeFiles($taskId)
    {
        \Log::debug("WE DID IT ".$taskId, [$this->files]);

        File::attachFiles($this->files, 'task', $taskId);

        $this->files = [];
    }

    public function handleAssignment($taskId, $newOwner)
    {
        \Log::debug("handling...", [$taskId, $newOwner]);
        // TODO: track activitiy, send notifications and whatever else
        DB::table('tasks')
            ->where('id', $taskId)
            ->update(['assigned_to' => $newOwner, 'updated_at' => now()]);
    }

    public function removeAssignment($taskId)
    {
        \Log::debug("handling removal...", [$taskId]);
        // TODO: track activitiy, send notifications and whatever else
        DB::table('tasks')
            ->where('id', $taskId)
            ->update(['assigned_to' => null, 'updated_at' => now()]);
    }

    public function updateCompletedBy($taskId, $userId)
    {
        \Log::debug("updateCompletedBy...", [$taskId, $userId]);
        // TODO: track activitiy, send notifications and whatever else
        DB::table('tasks')
            ->where('id', $taskId)
            ->update(['completed_by' => $userId, 'updated_at' => now()]);
    }

    public function updateCompletedDate($taskId, $date)
    {
        \Log::debug("updateCompletedDate...", [$taskId, $date]);
        // TODO: track activitiy, send notifications and whatever else
        DB::table('tasks')
            ->where('id', $taskId)
            ->update(['completed_date' => $date, 'updated_at' => now()]);
    }

    public function toggleTaskComplete($taskId)
    {
        $isComplete = DB::table('tasks')
                ->where('id', $taskId)
                ->whereNull('completed_date')
                ->count() === 0;

        \Log::debug("{$taskId}: ISCOMPEL ".($isComplete ? 'YES' : 'no'));

        if($isComplete) {
            $update = ['completed_date' => null, 'completed_by' => null, 'updated_at' => now()];
        } else {
            $update = ['completed_date' => date('Y-m-d'), 'completed_by' => auth()->user()->id, 'updated_at' => now()];
        }

        \Log::debug("{$taskId}: UPDATING WITH: ", $update);
        DB::table('tasks')
            ->where('id', $taskId)
            ->update($update);

        // TODO: Trigger notifications and whatever else
    }
}
