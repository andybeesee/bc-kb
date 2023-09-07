<?php

namespace App\Http\Controllers\API\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToggleCompleteController extends Controller
{
    public function __invoke(Request $request, Task $task)
    {
        if($task->is_complete) {
            $task->completed_date = null;
            $task->completed_by = null;
        } else {
            $task->completed_date = date('Y-m-d');
            $task->completed_by = auth()->user()->id;
        }

        $task->save();

        return $task->fresh(['completedBy']);
    }
}
