<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FlowerController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CarouselController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public routes
Route::get('/', function () {
    return Inertia::render('FlowerGallery'); 
});
Route::get('/ziggy-test', function () {
    return Inertia::render('ZiggyTest');
});
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Logout route
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('dashboard');
// Flower management routes for admin
Route::middleware(['auth'])->group(function () {
    Route::get('/flowers', [FlowerController::class, 'index'])->name('flowers.index'); // Catalog view
    Route::get('/flowers/manage', [FlowerController::class, 'manage'])->name('flowers.manage'); // Management view
    Route::get('/flowers/create', [FlowerController::class, 'create'])->name('flowers.create');
    Route::post('/flowers', [FlowerController::class, 'store'])->name('flowers.store');
    Route::get('/flowers/{flower}/edit', [FlowerController::class, 'edit'])->name('flowers.edit');
    Route::put('/flowers/{flower}', [FlowerController::class, 'update'])->name('flowers.update');
    Route::delete('/flowers/{flower}', [FlowerController::class, 'destroy'])->name('flowers.destroy');
    
});
Route::middleware(['auth'])->group(function () {
    Route::get('/carousel-management', fn () => Inertia::render('CarouselManagement'))->name('carousel.management');
    Route::post('/carousel', [CarouselController::class, 'store']);
    Route::delete('/carousel/{id}', [CarouselController::class, 'destroy']);
});

