<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [RegisterController::class, 'register']);

// Login Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
// Update the admin login route
Route::get('/admin/login', function () {
    return view('auth.admin-login');
})->name('admin.login.form');  // This matches the route name used in navbar

Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Update the dashboard route to include both auth and revalidate middleware
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Add these routes with your other authenticated routes
Route::middleware('auth')->group(function () {
    Route::middleware(['auth'])->group(function () {
        // Profile routes
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    });
    // Remove or comment out this route
    // Route::get('/become-author', function () {
    //     return view('become-author');
    // })->middleware('auth')->name('become-author');
});

// Author Routes
Route::middleware('auth:author')->group(function () {
    Route::get('/author/dashboard', [AuthorController::class, 'dashboard'])->name('author.dashboard');
    Route::post('/author/logout', [AuthorController::class, 'logout'])->name('author.logout');
    Route::get('/author/profile', [AuthorController::class, 'profile'])->name('author.profile');
    Route::get('/author/profile/edit', [AuthorController::class, 'edit'])->name('author.profile.edit');
    Route::put('/author/profile', [AuthorController::class, 'update'])->name('author.profile.update');
    Route::get('/author/profile/change-password', [AuthorController::class, 'changePassword'])->name('author.profile.change-password');
    Route::put('/author/profile/change-password', [AuthorController::class, 'updatePassword'])->name('author.profile.update-password');
    Route::middleware(['auth:author'])->group(function () {
        Route::resource('author/books', BookController::class)->names([
            'index' => 'author.books.index',
            'create' => 'author.books.create',
            'store' => 'author.books.store',
            'edit' => 'author.books.edit',
            'update' => 'author.books.update',
            'destroy' => 'author.books.destroy',
        ]);
    });
});
Route::get('/author/login', function () {
    return view('auth.author-login');
})->name('author.login');

Route::post('/author/login', [AuthorController::class, 'login'])->name('author.login.submit');
Route::get('/author/register', function () {
    return view('auth.author-register');
})->name('author.register');

Route::post('/author/register', [AuthorController::class, 'register'])->name('author.register.submit');

// Admin Routes
use App\Http\Controllers\Admin\BookManagementController;
use App\Http\Controllers\Admin\CategoryController;

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/books', [BookManagementController::class, 'index'])->name('admin.books.index');
    Route::post('/admin/books/{book}/approve', [BookManagementController::class, 'approve'])->name('admin.books.approve');
    Route::post('/admin/books/{book}/reject', [BookManagementController::class, 'reject'])->name('admin.books.reject');
    Route::resource('admin/categories', CategoryController::class)->except(['show', 'create', 'edit'])->names([
        'index' => 'admin.categories.index',
        'store' => 'admin.categories.store',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);
});