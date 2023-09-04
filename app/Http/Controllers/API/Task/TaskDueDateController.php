<?php

namespace App\Http\Controllers\API\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskDueDateController extends Controller
{
    public function __invoke(Request $request, Task $task)
    {
        $task->due_date = $request->get('due_date', null);
        $task->save();

        return $task->fresh(['completedBy', 'assignedTo']);
    }
}
