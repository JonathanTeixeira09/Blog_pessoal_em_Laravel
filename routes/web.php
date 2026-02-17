<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\PostController;
use \App\Http\Controllers\CommentController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about',[HomeController::class, 'about'])->name('about');

Route::controller(AuthController::class)->group(function (){
    Route::get('/login','index')->name('login.index');
    Route::post('/login','store')->name('login.store');
    Route::get('logout','destroy')->name('logout');
    Route::get('/createUser','show')->name('createuser.index')->Middleware('auth');
    Route::post('/createUser','create')->name('createuser.store')->Middleware('auth');
    Route::get('/listusers','listUsers')->name('listusers.index')->Middleware('auth');
    Route::get('/editUser/{id}','edit')->name('edituser.index')->Middleware('auth');
    Route::put('/editUser/{id}','update')->name('updateuser')->Middleware('auth');
    Route::delete('/destroyUser/{id}','destroyUser')->name('destroy.user')->Middleware('auth');
});

Route::controller(PostController::class)->group(function (){
    Route::get('/formpost','created')->name('formpost')->Middleware('auth');
    Route::post('/formpost','store')->name('formpost')->Middleware('auth');
    Route::get('/post/{post:slug}','show')->name('post');
    Route::get('/posts','allPosts')->name('posts');
    Route::get('/listposts','listPosts')->name('listposts.index')->Middleware('auth');
    Route::get('/editPost/{id}','edit')->name('editpost.index')->Middleware('auth');
//    Route::put('/editPost/{id}','update')->name('updatepost')->Middleware('auth');
    Route::delete('/destroypost/{id}','destroyPost')->name('destroy.post')->Middleware('auth');
});

Route::controller(CommentController::class)->group(function (){
//    Route::get('/comment/{comment}','destroy')->name('comment.destroy')->Middleware('auth');
    Route::delete('/comment/{comment}','destroy')->name('comment.destroy')->Middleware('auth');
    Route::post('/comment/{post}','store')->name('comment');
});

