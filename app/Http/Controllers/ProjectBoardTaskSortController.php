<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectBoardTaskSortController extends Controller
{
    public function __invoke(Request $request, Project $project, Board $board)
    {
        $boards = DB::table('tasks')
            ->where('board_id', $board->id)
            ->get()
            ->pluck('id', 'sort')
            ->toArray();

        foreach($request->get('items') as $data) {
            $taskId = $data['id'];
            $newSort = $data['sort'];

            $curSort = $boards[$taskId] ?? 0;
            if($curSort === $newSort) {
                continue;
            }

            DB::table('tasks')
                ->where('board_id', $board->id)
                ->where('id', $taskId)
                ->update([
                    'sort' => $newSort,
                ]);
        }

        return response('OK', 200);
    }
}
