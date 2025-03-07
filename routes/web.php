<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// dashboard route
Route::get('/dashboard',[PostController::class,'index'])->middleware(['auth'])->name('dashboard');
Route::get('/markasread',[PostController::class,'markasread'])->middleware(['auth'])->name('markasread');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // posts routes
    Route::resource('posts', PostController::class)->except(['index']);
    // comments routes
    Route::resource('comments',CommentController::class);
    // friends routes
    Route::get('/connections', [ConnectionController::class, 'index'])->name('connections.index');
    Route::post('/connections/{user}', [ConnectionController::class, 'sendRequest'])->name('connections.send');
    Route::post('/connections/accept/{user}', [ConnectionController::class, 'acceptRequest'])->name('connections.accept');
    Route::post('/connections/{user}/ignore', [ConnectionController::class, 'ignoreRequest'])->name('connections.ignore');
    Route::delete('/connections/{user}', [ConnectionController::class, 'removeConnection'])->name('connections.remove');


    Route::get('/myposts', [PostController::class, 'myposts'])->name('myposts');
    Route::get('/search', [PostController::class, 'search'])->name('search');

    // Recherche d'utilisateurs et hashtags
    Route::get('/search/users', [SearchController::class, 'searchUsers'])->name('search.users');
    Route::get('/hashtags/{hashtag}', [SearchController::class, 'showHashtag'])->name('hashtags.show');
    Route::get('/search/result', [SearchController::class, 'result'])->name('search.result');

});

require __DIR__.'/auth.php';
