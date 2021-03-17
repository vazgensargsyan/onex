<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/home/like', [HomeController::class, 'like'])->name('home.like');
Route::post('/home/dislike', [HomeController::class, 'dislike'])->name('home.dislike');
Route::post('/home/comment', [HomeController::class, 'comment'])->name('home.comment');
Route::get('/home/search', [HomeController::class, 'search'])->name('home.search');

Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/edit/{id?}', [CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category/update', [CategoryController::class, 'update'])->name('category.update');
Route::post('/category/delete', [CategoryController::class, 'delete'])->name('category.delete');

Route::get('/post', [PostController::class, 'index'])->name('post.index');
Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
Route::get('/post/edit/{id?}', [PostController::class, 'edit'])->name('post.edit');
Route::post('/post/update', [PostController::class, 'update'])->name('post.update');
Route::post('/post/delete', [PostController::class, 'delete'])->name('post.delete');
