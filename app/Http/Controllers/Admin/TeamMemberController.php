<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeamMemberController extends Controller
{
    public function store(Request $request, Team $team)
    {
        $this->validate($request, [
            'member' => [
                'required',
                'exists:users,id',
                Rule::unique('team_user', 'user_id')
                    ->where('team_id', $team->id),
            ],
        ]);

        $team->members()->attach($request->get('member'));

        return redirect()->route('admin.teams.show', $team);

    }

    public function destroy(Request $request, Team $team, User $member)
    {
        $team->members()->detach($member);

        return redirect()->route('admin.teams.show', $team);
    }

}
