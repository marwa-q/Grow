<?php
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    // dd(Auth::user()->role);
    return view('dashboard');
})->middleware(['auth', 'verified'])
    ->can('access', User::class)
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::post('/donate', [ActivityController::class, 'donate'])->name('donate')->middleware('auth');

Route::get('/activities/{categoryId?}', [ActivityController::class, 'index'])->name('activities.index');
Route::post('/join-activity/{activityId}', [ActivityController::class, 'joinActivity'])->name('join.activity')->middleware('auth');
Route::post('/activities/{activityId}/leave', [ActivityController::class, 'leaveActivity'])->name('leave.activity')->middleware('auth');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/volunteers', [AboutController::class, 'getVolunteers'])->name('volunteers.get');



require __DIR__ . '/auth.php';
