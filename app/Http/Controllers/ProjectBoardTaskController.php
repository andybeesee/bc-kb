<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectBoardTaskController extends Controller
{
    public function index(Project $project, Board $board)
    {
        return view('projects.boards.tasks.index')
            ->with('project', $project)
            ->with('board', $board);
    }

    public function create(Project $project, Board $board)
    {
        return view('projects.boards.tasks.create')
            ->with('project', $project)
            ->with('board', $board);
    }

    public function show(Project $project, Board $board, Task $task)
    {
        return view('projects.boards.tasks.show')
            ->with('project', $project)
            ->with('board', $board)
            ->with('task', $task);
    }

    public function edit(Project $project, Board $board, Task $task)
    {
        return view('projects.boards.tasks.edit')
            ->with('project', $project)
            ->with('board', $board)
            ->with('task', $task);
    }
}
