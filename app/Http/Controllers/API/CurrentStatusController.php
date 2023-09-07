<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CurrentStatus;
use Illuminate\Http\Request;

class CurrentStatusController extends Controller
{
    public function index($type, $id)
    {
        return CurrentStatus::with('creator')
            ->where('attached_type', $type)
            ->where('attached_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function show($type, $id)
    {
        return CurrentStatus::with('creator')
            ->where('attached_type', $type)
            ->where('attached_id', $id)
            ->orderBy('created_at', 'DESC')
            ->first();
    }


    public function store(Request $request, $type, $id)
    {
        $this->validate($request, [
            'status' => 'required',
        ]);

        $cs = new CurrentStatus();
        $cs->status = $request->get('status');
        $cs->attached_id = $id;
        $cs->attached_type = $type;
        $cs->save();

        return $cs->fresh(['creator']);
    }

    public function destroy(CurrentStatus $currentStatus)
    {

    }
}
