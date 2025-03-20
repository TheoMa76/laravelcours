<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/projets', [ProjectController::class, 'index'])->name('projets');
    Route::get('/projets/create', [ProjectController::class, 'create'])->name('projets.create');
    Route::post('/projets', [ProjectController::class, 'store'])->name('projets.store');
    Route::get('/projets/{id}', [ProjectController::class, 'show'])->name('projets.show');
    Route::get('/projets/{id}/contribute', [ProjectController::class, 'contributeForm'])->name('projets.contribute');
    Route::post('/projets/{id}/contribute', [ProjectController::class, 'contribute'])->name('projets.contribute.submit');
    Route::get('/projets/{id}/edit', [ProjectController::class, 'edit'])->name('projets.edit');
    Route::put('/projets/{id}', [ProjectController::class, 'update'])->name('projets.update');
    Route::delete('/projets/{id}', [ProjectController::class, 'destroy'])->name('projets.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';