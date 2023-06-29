<?php

namespace App\Http\Livewire;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BoardTaskList extends Component
{
    public Board $board;

    public function render()
    {
        $tasks = Task::where('board_id', $this->board->id)
            ->orderBy('sort')
            ->get();

        return view('livewire.board-task-list')
            ->with('tasks', $tasks);
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
