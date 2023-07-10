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
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', \App\Http\Controllers\DashboardController::class)->name('dashboard');

    Route::get('/files/{file}/download', \App\Http\Controllers\FileDownloadController::class)->name('files.download');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('projects', \App\Http\Controllers\ProjectController::class);
    Route::put('/projects/{project}/boards/sort', \App\Http\Controllers\ProjectBoardSortController::class)->name('projects.boards.sort');

    Route::resource('projects.boards', \App\Http\Controllers\ProjectBoardController::class);
    Route::resource('projects.boards.tasks', \App\Http\Controllers\ProjectBoardTaskController::class);

    Route::resource('boards', \App\Http\Controllers\BoardController::class);
    Route::resource('tasks', \App\Http\Controllers\TaskController::class);
});

Route::middleware(['auth', 'admin'])->name('admin.')->prefix('/admin')->group(function() {
    Route::resource('teams', \App\Http\Controllers\Admin\TeamController::class);
    Route::post('teams/{team}/members', [\App\Http\Controllers\Admin\TeamMemberController::class, 'store'])->name('teams.members.store');
    Route::delete('teams/{team}/members/{member}', [\App\Http\Controllers\Admin\TeamMemberController::class, 'destroy'])->name('teams.members.destroy');
});

require __DIR__.'/auth.php';
