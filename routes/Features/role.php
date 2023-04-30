<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

Route::middleware('auth')->prefix('admin')->group(function () {
  Route::get('/roles', [RoleController::class, 'index'])->name('roles.index')->middleware(['permission:role.index']);

  Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create')->middleware(['permission:role.create']);

  Route::post('/roles', [RoleController::class, 'store'])->name('roles.store')->middleware(['permission:role.create']);

  Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware(['permission:role.edit']);

  Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update')->middleware(['permission:role.edit']);

  Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware(['permission:role.delete']);
});
