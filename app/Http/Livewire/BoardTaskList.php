<?php

namespace App\Http\Livewire;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BoardTaskList extends Component
{
    public Board $board;

    protected $listeners = [
        'sorted' => 'handleSort',
        'assigned' => 'handleAssignment',
    ];

    public function render()
    {
        $tasks = Task::where('board_id', $this->board->id)
            ->orderBy('sort')
            ->get();

        return view('livewire.board-task-list')
            ->with('tasks', $tasks);
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
