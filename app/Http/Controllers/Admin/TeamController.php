<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::withCount('members')->orderBy('name')->paginate(25);

        return view('admin.teams.index')->with('teams', $teams);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:teams,name',
        ]);

        $team = new Team();
        $team->name = $request->get('name');
        $team->save();

        return redirect()->route('admin.teams.show', $team);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        $team->load('members');

        $newMemberOptions = User::whereNotIn('id', $team->members->pluck('id')->toArray())
            ->get();

        return view('admin.teams.show')
            ->with('team', $team)
            ->with('newMemberOptions', $newMemberOptions);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        return view('admin.teams.edit')->with('team', $team);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        $this->validate($request, [
            'name' => 'required|unique:teams,name,'.$team->id,
        ]);

        $team->name = $request->get('name');
        $team->save();

        return redirect()->route('admin.teams.show', $team);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        //
    }
}
