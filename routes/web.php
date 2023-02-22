<?php

use App\Http\Controllers\Admin\DashboardController as DashboardController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('guest.home');
})->name('guest.home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth' , 'verified'])->name('admin.')->prefix('admin/')->group(function(){
    Route::get('dashboard' , [DashboardController::class , 'index'])->name('dashboard');

    Route::prefix('')->name('pages.')->group(function () {
        Route::get('projects/trashed' , [AdminProjectController::class , 'trashed'])->name('projects.trashed');
        Route::get('projects/{project}/restore' , [AdminProjectController::class , 'restore'])->name('projects.restore');
        Route::get('projects/restore' , [AdminProjectController::class , 'restoreAll'])->name('projects.restoreAll');
        Route::delete('projects/{project}/forceDelete' , [AdminProjectController::class , 'forceDelete'])->name('projects.forceDelete');
        Route::delete('projects/forceDelete' , [AdminProjectController::class , 'emptyTrash'])->name('projects.emptyTrash');
        Route::resource('projects',AdminProjectController::class);
    });

});

require __DIR__.'/auth.php';