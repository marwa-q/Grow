<?php
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminActivityController;
use App\Http\Controllers\Admin\AdminPostsController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DonationController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\http\controllers\LandingPageController;


Route::get('/', [LandingPageController::class, 'index'])->name('home');

Route::get('/dashboard', function () {

    if (Auth::user() && (Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin')) {

    }
    return view('dashboard');
})->middleware(['auth', 'verified'])
    ->can('access', User::class)
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
     // Add this line:
     Route::delete('/profile/remove-photo', [ProfileController::class, 'removePhoto'])->name('profile.remove-photo');
     // Also add this route for email updates that's used in your modal form:
     Route::post('/profile/update-email', [ProfileController::class, 'updateEmail'])->name('profile.update-email');
});


Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('users', UserController::class);

    Route::get('activities', [AdminActivityController::class, 'index'])->name('dashboard.activities.index');
    Route::get('activities/create', [AdminActivityController::class, 'create'])->name('dashboard.activities.create');
    Route::get('activities/{activity}/edit', [AdminActivityController::class, 'edit'])->name('dashboard.activities.edit');
    Route::put('activities/{activity}', [AdminActivityController::class, 'update'])->name('activities.update');
    Route::post('activities', [AdminActivityController::class, 'store'])->name('activities.store');
    Route::get('activities/{activity}', [AdminActivityController::class, 'show'])->name('dashboard.activities.show');
    Route::delete('activities/{activity}', [AdminActivityController::class, 'destroy'])->name('dashboard.activities.destroy');

    // Admin Posts Routes
    Route::get('posts', [AdminPostsController::class, 'index'])->name('dashboard.posts.index');
    Route::get('posts/create', [AdminPostsController::class, 'create'])->name('dashboard.posts.create');
    Route::get('posts/{post}/edit', [AdminPostsController::class, 'edit'])->name('dashboard.posts.edit');
    Route::get('posts/{post}', [AdminPostsController::class, 'show'])->name('dashboard.posts.show');
    Route::delete('posts/{post}', [AdminPostsController::class, 'destroy'])->name('dashboard.posts.destroy');
    Route::post('posts', [AdminPostsController::class, 'store'])->name('dashboard.posts.store');
    Route::put('posts/{post}', [AdminPostsController::class, 'update'])->name('dashboard.posts.update');



    // Comments routes with only view and delete functionality
    Route::resource('comments', CommentController::class)->only(['index', 'show', 'destroy']);

    Route::resource('donations', DonationController::class)->only(['index', 'show']);
    Route::get('donation-statistics', [DonationController::class, 'statistics'])->name('donations.statistics');

})
    ->can('access', User::class);
require __DIR__ . '/auth.php';


Route::post('/donate', [ActivityController::class, 'donate'])->name('donate')->middleware('auth');

Route::get('/activities/{categoryId?}', [ActivityController::class, 'index'])->name('activities.index');
Route::post('/join-activity/{activityId}', [ActivityController::class, 'joinActivity'])->name('join.activity')->middleware('auth');
Route::post('/activities/{activityId}/leave', [ActivityController::class, 'leaveActivity'])->name('leave.activity')->middleware('auth');
Route::get('/activities/{activityId}', [ActivityController::class, 'show'])->name('activities.show');


Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');


Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/volunteers', [AboutController::class, 'getVolunteers'])->name('volunteers.get');



require __DIR__ . '/auth.php';


// Posts routes

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
// Posts likes routes

Route::post('/posts/{post}/like', [PostLikeController::class, 'toggleLike'])->middleware('auth')->name('posts.like');

// Posts comments routes

Route::post('/posts/{post}/comments', [PostCommentController::class, 'store'])->name('posts.comment');
Route::get('/posts/{post}/comments', [PostCommentController::class, 'fetchComments'])->name('posts.comments');

// Contact routes

Route::get('/contact', [ContactController::class, 'show'])->name('contact');

Route::middleware(['auth'])->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});