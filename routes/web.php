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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
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

// TODO: Admin middleware
Route::middleware('auth')->name('admin.')->prefix('/admin')->group(function() {
   Route::resource('teams', \App\Http\Controllers\Admin\TeamController::class);
});

require __DIR__.'/auth.php';
