<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class, 'index'])->name('main');
Route::get('about',[MainController::class,'about'])->name('main.about');
Route::get('filterpostsbycategory/{id}', [MainController::class, 'filterpostsbycategory'])->name('main.filterpostsbycategory');
Route::get('showpost/{id}', [MainController::class,'showpost'])->name('main.showpost');


/*-----------------------------------------COMMENTS----------------------------------------------- */
Route::post('/comment', [CommentController::class,'store'])->name('comment.store');//->middleware('auth');

/* ------------------------------------- LOGIN & CREATE ACCOUNT ---------------------------------- */
Route::get('/logins',[PublicController::class,'index'])->name('public.index');
Route::get('/createaccount',[PublicController::class,'create'])->name('public.create');
Route::post('/log', [PublicController::class, 'authenticate'])->name('public.authenticate');
Route::post('/create',[PublicController::class,'store'])->name('public.store');
//Route::post('/logouts', [PublicController::class, 'logout'])->name('public.logout');


/* ----------------------------------------USER--------------------------------------------------------------------------- */
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/fetchallusers', [UserController::class, 'fetchAllUsers'])->name('user.fetchAllUsers');
Route::post('/user/add', [UserController::class, 'store'])->name('user.store');
Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/delete', [UserController::class, 'destroy'])->name('user.destroy');

/* --------------------------------------CATEGORY----------------------------------------------- */
Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/fetchall', [CategoryController::class, 'getAllCategories'])->name('category.getAllCategories');
Route::post('/category/add', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/edit', [CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category/update', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/delete', [CategoryController::class, 'destroy'])->name('category.destroy');
/* -------------------------------------ROLE------------------------------------------------ */
Route::get('/role', [RoleController::class, 'index'])->name('role.index');
Route::get('/role/fetchall', [RoleController::class, 'fetchAllRoles'])->name('role.fetchAllRoles');
Route::post('/rol/add', [RoleController::class, 'store'])->name('role.store');
Route::get('/rol/edit', [RoleController::class, 'edit'])->name('role.edit');
Route::post('/rol/update', [RoleController::class, 'update'])->name('role.update');
Route::delete('/rol/delete', [RoleController::class, 'destroy'])->name('role.destroy');
/* --------------------------------------POST------------------------------------------------ */
Route::get('/post',[PostController::class,'index'])->name('post.index');
Route::get('/post/fetchall', [PostController::class, 'getFetchAllPosts'])->name('post.getFetchAllPosts');
Route::get('/post/add',[PostController::class,'create'])->name('post.create');
Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
Route::get('/post/{id}', [PostController::class, 'edit'])->name('post.edit');
Route::post('/post/update', [PostController::class, 'update'])->name('post.update');



Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
