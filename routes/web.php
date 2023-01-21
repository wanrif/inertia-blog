<?php

use App\Http\Controllers\Admin\DashboardCategoriesController;
use App\Http\Controllers\Admin\DashboardPostController;
use App\Http\Controllers\Admin\PermissionsResourceController;
use App\Http\Controllers\Admin\RoleResourceController;
use App\Http\Controllers\Admin\UserResourceController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

/**
 * * Home
 */
Route::get('/', function () {
    return Inertia::render('Main/Home');
})->name('home');

/**
 * * Blog Routes
 */
Route::get('/blog', [BlogController::class, 'index'])->middleware('web')->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->middleware('web')->name('blog.show');

/**
 * * Dashboard Routes
 */
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard/Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 * * Profile Routes
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * * Auth Routes
 */
require __DIR__.'/auth.php';

/**
 * * Dashboard Posts Routes
 */
Route::middleware(['auth', 'verified', 'role_or_permission:super-admin|admin|author|manage posts'])->group(function () {
    Route::get('/dashboard/posts/getSlug', [DashboardPostController::class, 'getSlug']);
    Route::resource('dashboard/posts', DashboardPostController::class, ['as' => 'dashboard']);
});

/**
 * * Dashboard Category Routes
 */
Route::resource('dashboard/categories', DashboardCategoriesController::class, ['as' => 'dashboard'])->middleware(['auth', 'verified', 'role_or_permission:super-admin|admin|manage categories'])->except(['create', 'show', 'edit']);

/**
 * * Dashboard Roles, Permissions and Users Routes
 * * Only Super Admin and Admin can access this routes
 */
Route::group(['middleware' => ['auth', 'verified', 'role:super-admin|admin']], function () {
    /**
     * * Dashboard Roles Routes
     */
    Route::resource('dashboard/roles', RoleResourceController::class)->except(['show']);

    /**
     * * Dashboard Permissions Routes
     */
    Route::resource('dashboard/permissions', PermissionsResourceController::class)->except(['create', 'show', 'edit']);

    /**
     * * Dashboard Users Routes
     */
    Route::resource('dashboard/users', UserResourceController::class)->except('show');
});