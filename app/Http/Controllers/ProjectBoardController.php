<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectBoardController extends Controller
{
    public function index(Project $project)
    {

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
        return view('projects.boards.show')->with('project', $project);
    }
}
