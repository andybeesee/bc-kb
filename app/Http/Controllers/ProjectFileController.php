<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectFileController extends Controller
{
    public function __invoke(Project $project)
    {
        return view('projects.files')->with('project', $project);
    }
}
