<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;
use App\Models\Project;
use App\Models\Board;
use App\Models\Task;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

Breadcrumbs::for('tasks.show', function(BreadcrumbTrail $trail, Task $task) {
    $trail->parent('projects.show', $task->project);
   $trail->push('Task Detail', route('tasks.show', $task));
});

Breadcrumbs::for('projects.index', function (BreadcrumbTrail $trail) {
    $trail->push('Projects', route('projects.index'));
});

Breadcrumbs::for('projects.create', function (BreadcrumbTrail $trail) {
    $trail->parent('projects.index');
    $trail->push('New Project',route('projects.create'));
});

Breadcrumbs::for('projects.show', function (BreadcrumbTrail $trail, Project $project) {
    $trail->parent('projects.index');
    $name = str_contains(url()->current(), '/projects/'.$project->id) ? 'Project Dashboard' : $project->name;
    $trail->push($name, route('projects.show', $project));
});

Breadcrumbs::for('projects.edit', function (BreadcrumbTrail $trail, Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('Edit', route('projects.edit', $project));
});

Breadcrumbs::for('projects.files.index', function (BreadcrumbTrail $trail, Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('Files', route('projects.files.index', $project));
});

Breadcrumbs::for('projects.discussions.index', function (BreadcrumbTrail $trail, Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('Discussions', route('projects.discussions.index', $project));
});

Breadcrumbs::for('projects.boards.index', function (BreadcrumbTrail $trail, Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('Boards', route('projects.boards.index', $project));
});

Breadcrumbs::for('projects.boards.show', function (BreadcrumbTrail $trail, Project $project, Board $board) {
    $trail->parent('projects.boards.index', $project);
    $trail->push('Board Detail', route('projects.boards.show', [$project, $board]));
});

Breadcrumbs::for('projects.boards.create', function (BreadcrumbTrail $trail, Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('New Board', route('projects.boards.create', $project));
});

Breadcrumbs::for('projects.boards.edit', function (BreadcrumbTrail $trail, Project $project, Board $board) {
    $trail->parent('projects.boards.show', $project, $board);
    $trail->push('Edit Board', route('projects.boards.edit', [$project, $board]));
});

Breadcrumbs::for('projects.boards.tasks.index', function (BreadcrumbTrail $trail, Project $project, Board $board) {
    $trail->parent('projects.boards.show', $project, $board);
    $trail->push('Tasks', route('projects.boards.tasks.index', [$project, $board]));
});

Breadcrumbs::for('projects.boards.tasks.show', function (BreadcrumbTrail $trail, Project $project, Board $board, Task $task) {
    $trail->parent('projects.boards.tasks.index', $project, $board);
    $trail->push('Task Detail', route('projects.boards.tasks.show', [$project, $board, $task]));
});

Breadcrumbs::for('projects.boards.tasks.edit', function (BreadcrumbTrail $trail, Project $project, Board $board, Task $task) {
    $trail->parent('projects.boards.tasks.show', $project, $board, $task);
    $trail->push('Edit Task', route('projects.boards.tasks.edit', [$project, $board, $task]));
});



/*************************************** ADMIN TEAMS ***************************************/
Breadcrumbs::for('admin.teams.index', function(BreadcrumbTrail $trail) {
    $trail->push('Teams', route('admin.teams.index'));
});

Breadcrumbs::for('admin.teams.create', function(BreadcrumbTrail $trail) {
    $trail->parent('admin.teams.index');
    $trail->push('New Team', route('admin.teams.create'));
});

Breadcrumbs::for('admin.teams.show', function(BreadcrumbTrail $trail, \App\Models\Team $team) {
    $trail->parent('admin.teams.index');
    $trail->push($team->name, route('admin.teams.show', $team));
});

Breadcrumbs::for('admin.teams.edit', function(BreadcrumbTrail $trail, \App\Models\Team $team) {
    $trail->parent('admin.teams.show', $team);
    $trail->push('Editing', route('admin.teams.edit', $team));
});



