<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('auth')->prefix('admin')->group(function () {
  Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware(['permission:user.index']);

  Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware(['permission:user.create']);

  Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware(['permission:user.create']);

  Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware(['permission:user.edit']);

  Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update')->middleware(['permission:user.edit']);

  Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware(['permission:user.delete']);

  Route::get('/users/change-password/{user}/edit', [UserController::class, 'change_password'])->name('users.change_password')->middleware(['permission:user.edit']);

  Route::put('/users/update-password/{user}', [UserController::class, 'update_password'])->name('users.update_password')->middleware(['permission:user.edit']);
});
