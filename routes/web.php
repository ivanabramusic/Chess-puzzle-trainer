<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PuzzleController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/puzzles/create', [PuzzleController::class, 'create'])->name('puzzles.create');
    Route::post('/puzzles', [PuzzleController::class, 'store'])->name('puzzles.store');
    Route::get('/puzzle/play', [PuzzleController::class, 'play'])->name('puzzles.play');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/puzzles', [AdminController::class, 'puzzles'])->name('admin.puzzles');

    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

    Route::put('/admin/puzzles/{puzzle}', [AdminController::class, 'updatePuzzle'])->name('admin.puzzles.update');
    Route::delete('/admin/puzzles/{puzzle}', [AdminController::class, 'deletePuzzle'])->name('admin.puzzles.delete');
});

require __DIR__ . '/auth.php';
