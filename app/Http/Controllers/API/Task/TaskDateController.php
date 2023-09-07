<?php

namespace App\Http\Controllers\API\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskDateController extends Controller
{
    public function dueDate(Request $request, Task $task)
    {
        $task->due_date = $request->get('due_date', null);
        $task->save();

        return $task->fresh(['completedBy', 'assignedTo']);
    }

    public function completedDate(Request $request, Task $task)
    {
        $this->validate($request, [
            'date' => 'required|date',
        ]);

        $task->completed_date = $request->get('date');
        $task->save();

        return $task->fresh(['completedBy', 'assignedTo']);
    }
}
