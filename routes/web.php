<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\Admin\PermissionsResourceController;
use App\Http\Controllers\Admin\RoleResourceController;

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
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('home');

/**
 * * Dashboard Routes
 */
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 * * Auth Routes
 */
require __DIR__.'/auth.php';

/**
 * * Dashboard Posts Routes
 */
Route::middleware(['auth', 'verified', 'role_or_permission:super-admin|admin|can manage posts'])->group(function () {
    Route::get('/dashboard/posts/getSlug', [DashboardPostController::class, 'getSlug']);
    Route::resource('dashboard/posts', DashboardPostController::class, ['as' => 'dashboard']);
});

/**
 * * Dashboard Roles Routes
 */
Route::resource('dashboard/roles', RoleResourceController::class)->middleware(['auth', 'verified', 'role:super-admin|admin'])->except(['show']);

/**
 * * Dashboard Permissions Routes
 */
Route::resource('dashboard/permissions', PermissionsResourceController::class)->middleware(['auth', 'verified', 'role:super-admin|admin'])->except(['show', 'edit']);

/**
 * * Post Routes
 */
// Route::resource('posts', PostController::class)->except(['create', 'edit', 'update', 'destroy']);
