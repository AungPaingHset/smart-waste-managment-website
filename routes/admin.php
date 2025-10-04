<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminNewsController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes
    Route::middleware('guest:admin')->group(function () {
       Route::get('login', [AdminAuthController::class, 'showLoginForm'])
    ->middleware('admin.ip')
    ->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])
    ->middleware('admin.ip');
    });

    // Authenticated admin routes
    Route::middleware('admin')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
        
        // User management
        Route::get('users', [AdminUserController::class, 'index'])->name('users');
        Route::get('users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        
        // Post management
        Route::get('articles', [AdminUserController::class, 'articles'])->name('articles');
        Route::get('articles/{article}', [AdminUserController::class, 'showarticle'])->name('articles.show');
        Route::delete('articles/{article}', [AdminUserController::class, 'deleteArticle'])->name('articles.delete');
        // Route::delete('articles/bulk-delete', [AdminUserController::class, 'bulkDelete'])->name('articles.bulk-delete');
        
        // Comment management
        Route::get('comments', [AdminUserController::class, 'comments'])->name('comments');
         Route::get('comments/{comment}', [AdminUserController::class, 'showcomment'])->name('comments.show');
        // Route::patch('comments/{comment}/status', [AdminUserController::class, 'updateCommentStatus'])->name('comments.status');
        Route::delete('comments/{comment}', [AdminUserController::class, 'deleteComment'])->name('comments.delete');


         // News management
        Route::resource('news', AdminNewsController::class);
    });
});