<?php

namespace App\Http\Controllers\API\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskAssignmentController extends Controller
{
    public function __invoke(Request $request, Task $task)
    {
        $task->assigned_to = $request->get('user', null);
        $task->save();

        return $task->fresh(['assignedTo']);
    }
}
