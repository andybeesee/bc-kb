<?php

namespace App\Http\Controllers\API\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskUserController extends Controller
{
    public function updateAssigned(Request $request, Task $task)
    {
        $task->assigned_to = $request->get('user', null);
        $task->save();

        return $task->fresh(['assignedTo']);
    }

    public function updateCompleted(Request $request, Task $task)
    {
        $this->validate($request, [
            'user' => 'required|exists:users,id',
        ]);

        $task->completed_by = $request->get('user', null);
        $task->save();

        return $task->fresh(['assignedTo', 'completedBy']);
    }
}
