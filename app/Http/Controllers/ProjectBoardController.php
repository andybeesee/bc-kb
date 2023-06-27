<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectBoardController extends Controller
{
    public function index(Project $project)
    {
        if($project->boards()->count() > 0) {
            return redirect()->route('projects.boards.show', [$project, $project->boards()->first()]);
        }

        return view('projects.boards.index')->with('project', $project);
    }

    public function create(Request $request, Project $project)
    {
        $how = $request->get('how', 'create');

        return view('projects.boards.create')
            ->with('project', $project)
            ->with('how', $how);
    }

    public function store(Request $request, Project $project)
    {

    }

    public function show(Project $project, Board $board)
    {
        $project->load([
            'boards' => fn($q) => $q->addTaskCounts(),
        ]);

        return view('projects.boards.show')
            ->with('project', $project)
            ->with('board', $board);
    }
}
