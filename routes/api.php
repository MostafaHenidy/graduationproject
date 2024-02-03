<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HospitalsController;
use App\Http\Controllers\CafesController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\SchoolsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Profile\AvatarController;

Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [AvatarController::class, 'update'])->name('avatar.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::apiResource('/hospitals', HospitalsController::class)->except(['create','edit'])
    ->names([
        'store' => 'hospitals.store',
        'update' => 'hospitals.update',
        'delete' => 'hospitals.delete',
        'show' => 'hospitals.show',
    ]);
Route::apiResource('/cafes', CafesController::class)->except(['create','edit'])
    ->names([
        'store' => 'cafes.store',
        'update' => 'cafes.update',
        'delete' => 'cafes.delete',
        'show' => 'cafes.show',
    ]);
Route::apiResource('/jobs', JobsController::class)->except(['create','edit'])
    ->names([
        'store' => 'jobs.store',
        'update' => 'jobs.update',
        'delete' => 'jobs.delete',
        'show' => 'jobs.show',
    ]);
Route::apiResource('/schools', SchoolsController::class)->except(['create','edit'])
    ->names([
        'store' => 'schools.store',
        'update' => 'schools.update',
        'delete' => 'schools.delete',
        'show' => 'schools.show',
    ]);