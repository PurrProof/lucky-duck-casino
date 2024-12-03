<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\GameController;
use App\Http\Middleware\CheckValidUntil;

Route::get('/', [UserController::class, 'showRegForm'])->name('user.register');
Route::post('/register', [UserController::class, 'register'])->name('user.register.submit');
Route::get('/login/{uuid}', [UserController::class, 'login'])->name('user.login');

Route::get('/login', fn() => redirect()->route('user.register'))->name('login');

Route::middleware(['auth', CheckValidUntil::class])->group(function () {
    Route::get('/dashboard', [UserController::class, 'showDashboard'])->name('dashboard');
    Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');
    Route::post('/links/generate', [LinkController::class, 'generateLink'])->name('links.generate');
    Route::post('/links/deactivate', [LinkController::class, 'deactivateLink'])->name('links.deactivate');
    Route::post('/games/play', [GameController::class, 'playGame'])->name('games.play');
});
