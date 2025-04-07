<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminContributionController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('');


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

Route::middleware([EnsureUserIsAdmin::class])->group(function () {
    Route::get('/admin/projets', [AdminProjectController::class, 'index'])->name('admin.projects.index');
    Route::get('/admin/projets/create', [AdminProjectController::class, 'create'])->name('admin.projects.create');
    Route::get('/admin/projets/{id}', [AdminProjectController::class, 'show'])->name('admin.projects.show');
    Route::post('/admin/projets', [AdminProjectController::class, 'store'])->name('admin.projects.store');
    Route::post('/admin/projets/{id}/validate', [AdminProjectController::class, 'validateProject'])->name('admin.projects.validate');
    Route::get('/admin/projets/{id}/edit', [AdminProjectController::class, 'edit'])->name('admin.projects.edit');
    Route::put('/admin/projets/{id}', [AdminProjectController::class, 'update'])->name('admin.projects.update');
    Route::delete('/admin/projets/{id}', [AdminProjectController::class, 'destroy'])->name('admin.projects.destroy');

    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/admin/contributions', [AdminContributionController::class, 'index'])->name('admin.contributions.index');    

    Route::get('/admin/dashboard', [AdminHomeController::class, 'stats'])->name('admin.dashboard');
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