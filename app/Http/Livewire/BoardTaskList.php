<?php

namespace App\Http\Livewire;

use App\Models\Board;
use App\Models\File;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class BoardTaskList extends Component
{
    use WithFileUploads;

    public Board $board;

    public $files;

    protected $listeners = [
        'sorted' => 'handleSort',
        'assigned' => 'handleAssignment',
        'removeAssigned' => 'removeAssignment',
        'saveFiles' => 'storeFiles',
    ];

    public function render()
    {
        $tasks = Task::withCount('files')
            ->where('board_id', $this->board->id)
            ->orderBy('sort')
            ->get();

        return view('livewire.board-task-list')
            ->with('tasks', $tasks);
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
            ->where('board_id', $this->board->id)
            ->update(['assigned_to' => $newOwner, 'updated_at' => now()]);
    }

    public function removeAssignment($taskId)
    {
        \Log::debug("handling removal...", [$taskId]);
        // TODO: track activitiy, send notifications and whatever else
        DB::table('tasks')
            ->where('id', $taskId)
            ->where('board_id', $this->board->id)
            ->update(['assigned_to' => null, 'updated_at' => now()]);
    }

    public function handleSort($items)
    {
        $boards = DB::table('tasks')
            ->where('board_id', $this->board->id)
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
                ->where('board_id', $this->board->id)
                ->where('id', $taskId)
                ->update([
                    'sort' => $newSort,
                ]);
        }
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
