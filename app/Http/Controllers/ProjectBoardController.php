<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProjectBoardController extends Controller
{
    public function index(Project $project)
    {
        if($project->boards()->count() > 0) {
            // return redirect()->route('projects.boards.show', [$project, $project->boards()->first()]);
        }

        $project->load(['boards' => fn($bq) => $bq->addTaskCounts()]);
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
        $this->validate($request, [
            'name' => [
                'required',
                Rule::unique('boards', 'name')
                    ->where('project_id', $project->id)
            ],
            'due_date' => 'nullable|date',
        ]);

        $board = new Board();
        $board->project_id = $project->id;
        $board->name = $request->get('name');
        $board->due_date = $request->get('due_date');
        $board->sort = DB::table('boards')->where('project_id', $project->id)->max('sort') + 1;
        $board->save();

        if($request->filled('tasks')) {
            $insert = [];
            $newTasks = array_unique(preg_split("/\r\n|\n|\r/", $request->get('tasks')));
            foreach($newTasks as $index => $taskName) {
                $insert[] = [
                    'name' => $taskName,
                    'board_id' => $board->id,
                    'sort' => $index,
                ];
            }

            DB::table('tasks')->insert($insert);
        }

        return redirect()->route('projects.boards.show', [$project, $board]);
    }

    public function show(Project $project, Board $board)
    {
        return view('projects.boards.show')
            ->with('project', $project)
            ->with('board', $board);
    }

    public function edit(Project $project, Board $board)
    {
        return view('projects.boards.edit')
            ->with('project', $project)
            ->with('board', $board);
    }
}
