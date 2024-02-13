<?php

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\HospitalsController;
use App\Http\Controllers\CafesController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\SchoolsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Profile\AvatarController;
use App\Models\User;
use OpenAI\Laravel\Facades\OpenAI;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [AvatarController::class, 'update'])->name('avatar.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('/hospitals', HospitalsController::class)->except(['create', 'edit'])
    ->names([
        'store' => 'hospitals.store',
        'update' => 'hospitals.update',
        'delete' => 'hospitals.delete',
        'show' => 'hospitals.show',
    ]);
Route::resource('/cafes', CafesController::class)->except(['create', 'edit'])
    ->names([
        'store' => 'cafes.store',
        'update' => 'cafes.update',
        'delete' => 'cafes.delete',
        'show' => 'cafes.show',
    ]);
Route::resource('/jobs', JobsController::class)->except(['create', 'edit'])
    ->names([
        'store' => 'jobs.store',
        'update' => 'jobs.update',
        'delete' => 'jobs.delete',
        'show' => 'jobs.show',
    ]);
Route::resource('/schools', SchoolsController::class)->except(['create', 'edit'])
    ->names([
        'store' => 'schools.store',
        'update' => 'schools.update',
        'delete' => 'schools.delete',
        'show' => 'schools.show',
    ]);

Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
});
Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();
    // User::updateOrCreate(['email' => $user->email],[
    //     'name' => $user->name,
    //     'password' => $user->password, 
    // ]);
    dd($user->email);
});

// Route::get('/openai',function(){


// $result = OpenAI::completions()->create([
//     'model' => 'text-davinci-003',
//     'prompt' =>'PHP is',
// ]);

// echo $result['choices'][0]['text']; 
// });
require __DIR__ . '/auth.php';
