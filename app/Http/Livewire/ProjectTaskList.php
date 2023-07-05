<?php

namespace App\Http\Livewire;

use App\Models\File;
use App\Models\Task;
use App\Models\TaskGroup;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ProjectTaskList extends Component
{
    use WithFileUploads;

    public int $projectId;

    public $files;

    protected $listeners = [
        'assigned' => 'handleAssignment',
        'removeAssigned' => 'removeAssignment',
        'saveFiles' => 'storeFiles',
        'sorted' => 'handleSort',
    ];

    public function render()
    {
        $groups = TaskGroup::with(['tasks' => fn($tq) => $tq->with('assignedTo')->withCount('files')])
            ->where('project_id', $this->projectId)
            ->orderBy('sort')
            ->get();

        $tasks = Task::with(['assignedTo'])
            ->withCount('files')
            ->where('project_id', $this->projectId)
            ->whereNull('task_group_id')
            ->orderBy('sort')
            ->get();

        return view('livewire.project-task-list')
            ->with('tasks', $tasks)
            ->with('groups', $groups);
    }


    public function handleSort($items)
    {
        $boards = DB::table('tasks')
            ->where('project_id', $this->projectId)
            ->get()
            ->pluck('id', 'sort')
            ->toArray();

        foreach($items as $data) {
            $taskId = $data['id'];
            $newSort = $data['sort'];

            $curSort = $boards[$taskId] ?? 0;
            if($curSort === $newSort) {
                continue;
            }

            DB::table('tasks')
                ->where('project_id', $this->projectId)
                ->where('id', $taskId)
                ->update([
                    'sort' => $newSort,
                ]);
        }
    }

    public function deleteGroup($id)
    {
        // TODO: Shoudl this delete all nested items? it should probably be an option when clicked
        DB::table('tasks')
            ->where('id', $id)
            ->delete();
    }

    public function storeFiles($taskId)
    {
        \Log::debug("WE DID IT ".$taskId, [$this->files]);

        /** @var TemporaryUploadedFile $tempFile */
        foreach($this->files as $tempFile) {
            $path = 'tasks/'.$taskId.'/'.$tempFile->getFilename();
            $tempFile->store($path);
            $file = new File();
            $file->filename = $tempFile->getClientOriginalName();
            $file->location = $path;
            $file->attached_type = 'task';
            $file->attached_id = $taskId;
            $file->save();
        }

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


    public function toggleTask($taskId)
    {
        $isComplete = DB::table('tasks')
                ->where('id', $taskId)
                ->whereNull('completed_date')
                ->count() === 0;

        \Log::debug("{$taskId}: ISCOMPEL ".($isComplete ? 'YES' : 'no'));

        if($isComplete) {
            $update = ['completed_date' => null];
        } else {
            $update = ['completed_date' => date('Y-m-d')];
        }

        \Log::debug("{$taskId}: UPDATING WITH: ", $update);
        DB::table('tasks')
            ->where('id', $taskId)
            ->update($update);

        // TODO: Trigger notifications and whatever else
    }
}
