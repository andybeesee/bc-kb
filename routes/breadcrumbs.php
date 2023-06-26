<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

Breadcrumbs::for('projects.index', function (BreadcrumbTrail $trail) {
    $trail->push('Projects', route('projects.index'));
});

Breadcrumbs::for('projects.show', function (BreadcrumbTrail $trail, \App\Models\Project $project) {
    $trail->parent('projects.index');
    $trail->push($project->name, route('projects.show', $project));
});

Breadcrumbs::for('projects.edit', function (BreadcrumbTrail $trail, \App\Models\Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('Edit', route('projects.edit', $project));
});

Breadcrumbs::for('projects.boards.index', function (BreadcrumbTrail $trail, \App\Models\Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('Boards', route('projects.boards.index', $project));
});


Breadcrumbs::for('projects.boards.create', function (BreadcrumbTrail $trail, \App\Models\Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('New Board', route('projects.boards.create', $project));
});

Breadcrumbs::for('boards.show', function (BreadcrumbTrail $trail, \App\Models\Board $board) {
    $trail->parent('projects.boards.index', $board->project);
    $trail->push($board->name, route('boards.show', $board));
});
