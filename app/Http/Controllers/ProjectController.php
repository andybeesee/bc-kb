<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with(['team', 'owner'])
            ->orderBy('name')
            ->paginate(25);

        return view('projects.index')->with('projects', $projects);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $allowedStatuses = implode(',', array_keys(config('statuses')));
        $this->validate($request, [
            'name' => 'required|unique:projects',
            'status' => 'required|in:'.$allowedStatuses,
            'due_date' => 'nullable|date',
            'owner' => 'nullable|exists:users,id',
            'team' => 'nullable|exists:teams,id',
        ]);

        $project = new Project();
        $project->name = $request->get('name');
        $project->description = $request->get('description');
        $project->status = $request->get('status');
        $project->due_date = $request->get('due_date');
        $project->owner_id = $request->get('owner');
        $project->team_id = $request->get('team');
        $project->save();

        $board = new Board();
        $board->name = 'Tasks';
        $board->project_id = $project->id;
        $board->save();

        return redirect()->route('projects.show', $project);

    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load([
            'boards' => fn($q) => $q->withOpenTasks()->addTaskCounts(),
        ]);

        return view('projects.show')->with('project', $project);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('projects.edit')->with('project', $project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $allowedStatuses = implode(',', array_keys(config('statuses')));
        $this->validate($request, [
            'name' => 'required|unique:projects,name,'.$project->id,
            'status' => 'required|in:'.$allowedStatuses,
            'due_date' => 'nullable|date',
            'owner' => 'nullable|exists:users,id',
            'team' => 'nullable|exists:teams,id',
        ]);

        $project->name = $request->get('name');
        $project->description = $request->get('description');
        $project->status = $request->get('status');
        $project->due_date = $request->get('due_date');
        $project->owner_id = $request->get('owner');
        $project->team_id = $request->get('team');
        $project->save();

        return redirect()->route('projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
