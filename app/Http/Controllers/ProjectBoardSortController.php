<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectBoardSortController extends Controller
{
    public function __invoke(Request $request, Project $project)
    {
        $boards = DB::table('boards')
            ->where('project_id', $project->id)
            ->get()
            ->pluck('id', 'sort')
            ->toArray();

        foreach($request->get('items') as $data) {
            $boardId = $data['id'];
            $newSort = $data['sort'];

            $curSort = $boards[$boardId] ?? 0;
            if($curSort === $newSort) {
                continue;
            }

            DB::table('boards')
                ->where('project_id', $project->id)
                ->where('id', $boardId)
                ->update([
                    'sort' => $newSort,
                ]);
        }

        return response('OK', 200);
    }
}
