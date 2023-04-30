<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartementController;

Route::middleware('auth')->prefix('admin')->group(function () {
  Route::get('/departements', [DepartementController::class, 'index'])->name('departements.index')->middleware(['permission:departement.index']);

  Route::get('/departements/create', [DepartementController::class, 'create'])->name('departements.create')->middleware(['permission:departement.create']);

  Route::post('/departements', [DepartementController::class, 'store'])->name('departements.store')->middleware(['permission:departement.create']);

  Route::get('/departements/{departement}/edit', [DepartementController::class, 'edit'])->name('departements.edit')->middleware(['permission:departement.edit']);

  Route::put('/departements/{departement}', [DepartementController::class, 'update'])->name('departements.update')->middleware(['permission:departement.edit']);

  Route::delete('/departements/{departement}', [DepartementController::class, 'destroy'])->name('departements.destroy')->middleware(['permission:departement.delete']);
});
