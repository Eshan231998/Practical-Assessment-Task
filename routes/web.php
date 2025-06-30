<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('Auth/Login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:Admin,Data Entry,Viewer')->group(function () {
        Route::get('/personsCreate', [PersonController::class, 'create'])->name('persons.create');
        Route::post('/persons', [PersonController::class, 'store']);
        Route::get('/personsEdit', [PersonController::class, 'edit']);
        Route::put('/personsUpdate', [PersonController::class, 'update']);
        Route::delete('/personsDelete', [PersonController::class, 'destroy'])->name('persons.destroy');


        //person validations
        Route::post('/check-national-id', [PersonController::class, 'nicUnique'])->name('persons.nic.unique');
    });
});

require __DIR__ . '/auth.php';
