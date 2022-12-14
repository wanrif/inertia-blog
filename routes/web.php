<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\DashboardPostController;

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
 * * Posts Routes
 */
Route::get('/dashboard/posts/getSlug', [DashboardPostController::class, 'getSlug'])->middleware(['auth', 'verified']);
Route::resource('dashboard/posts', DashboardPostController::class)->middleware(['auth', 'verified']);