<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SocialAuthController;
use App\Models\User;

require __DIR__.'/admin.php';
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
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/detail/{id}', [ArticleController::class, 'detail']);
Route::get('/articles/delete/{id}', [ArticleController::class, 'delete']);


Route::get("/articles/add" , [ArticleController::class , 'add']);
Route::post("/articles/add" , [ArticleController::class , 'create']);

Route::post("/comments/add", [CommentController::class, 'create']);
Route::get("/comments/delete/{id}", [CommentController::class, 'delete']);

Route::post("/articles/edit/{id}" , [ArticleController::class , 'update']);
Route::get("/articles/edit/{id}" , [ArticleController::class , 'edit']);



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);


Route::get('/ebin', [App\Http\Controllers\EbinController::class, 'index'])->name('ebin');;

Route::get('/', function() {
    return view("main");
});

Route::get('/test', function() {
    return view("test");
});





// Social authentication routes
Route::get('/auth/{provider}', [SocialAuthController::class, 'redirect'])
    ->where('provider', 'github|google|facebook');

Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])
    ->where('provider', 'github|google|facebook');