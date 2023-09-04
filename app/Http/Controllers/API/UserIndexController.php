<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserIndexController extends Controller
{
    protected $filtersApplied = false;

    public function __invoke(Request $request)
    {
        $q = User::query();

        $q->where(function($fq) use($request) {
            if($request->filled('search')) {
                $this->filtersApplied = true;
                $term = "%".$request->get('search')."%";
                $fq->where('name', 'LIKE', $term)->orWhere('username', 'LIKE', $term);
            }

            // TODO: more filters: current, inactive, team, etc.

            return $fq;
        });

        if($request->filled('include') && $this->filtersApplied) {
            $q = $q->orWhere('id', $request->get('include'));
        }

        return $q->paginate(
            $request->get('per_page', 25),
        );
    }
}
