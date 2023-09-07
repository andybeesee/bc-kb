<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if(auth()->check()) {
        return redirect()->route('projects.index', ['tab' => 'dashboard']);
    }

    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    // Route::get('/app', lw\Livewire\ProjectIndexPage::class)->name('app');

    Route::get('/files/{file}/download', \App\Http\Controllers\FileDownloadController::class)->name('files.download');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::get('/templates', lw\Livewire\Template\TemplateIndexPage::class)->name('templates.index');
    // Route::get('/project-templates/{projectTemplate}', lw\Livewire\Template\ProjectTemplateDetailPage::class)->name('project-templates.show');
    // Route::get('/checklist-templates/{checklistTemplate}', lw\Livewire\Template\ChecklistTemplateDetailPage::class)->name('checklist-templates.show');
//
    Route::resource('projects', \App\Http\Controllers\ProjectController::class);
    Route::resource('checklists', \App\Http\Controllers\ChecklistController::class);
    Route::resource('tasks', \App\Http\Controllers\TaskController::class);
    // Route::put('/projects/{project}/boards/sort', \App\Http\Controllers\ProjectBoardSortController::class)->name('projects.boards.sort');
    // Route::get('/projects/{project}/discussions', \App\Http\Controllers\ProjectDiscussionController::class)->name('projects.discussions.index');
    // Route::get('/projects/{project}/files', \App\Http\Controllers\ProjectFileController::class)->name('projects.files.index');
//
    // Route::get('/checklists/{checklist}', lw\Livewire\ChecklistDetailPage::class)->name('checklists.show');
//
    // Route::resource('projects.boards', \App\Http\Controllers\ProjectBoardController::class);
    // Route::resource('projects.boards.tasks', \App\Http\Controllers\ProjectBoardTaskController::class);
//
    // Route::resource('boards', \App\Http\Controllers\BoardController::class);
    // Route::resource('tasks', \App\Http\Controllers\TaskController::class);
});

Route::middleware(['auth', 'admin'])->name('admin.')->prefix('/admin')->group(function() {
    // Route::resource('teams', \App\Http\Controllers\Admin\TeamController::class);
    // Route::post('teams/{team}/members', [\App\Http\Controllers\Admin\TeamMemberController::class, 'store'])->name('teams.members.store');
    // Route::delete('teams/{team}/members/{member}', [\App\Http\Controllers\Admin\TeamMemberController::class, 'destroy'])->name('teams.members.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->prefix('api')->name('api.')->group(function() {
    Route::get('/users', \App\Http\Controllers\API\UserIndexController::class)->name('users.index');

    Route::get('/projects', \App\Http\Controllers\API\ProjectIndexController::class)->name('projects.index');

    Route::get('/tasks', \App\Http\Controllers\API\TaskIndexController::class)->name('tasks.index');
    Route::put('/tasks/{task}/due-date', \App\Http\Controllers\API\Task\TaskDueDateController::class)->name('tasks.update.due-date');
    Route::put('/tasks/{task}/assigned', \App\Http\Controllers\API\Task\TaskAssignmentController::class)->name('tasks.update.assigned');
});
