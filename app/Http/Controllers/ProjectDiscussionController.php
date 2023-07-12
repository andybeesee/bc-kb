<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectDiscussionController extends Controller
{
    public function __invoke(Project $project)
    {
        return view('projects.discussions')->with('project', $project);
    }
}
