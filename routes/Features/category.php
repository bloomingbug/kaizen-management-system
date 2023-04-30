<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::middleware('auth')->prefix('admin')->group(function () {
  Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index')->middleware(['permission:category.index']);

  Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create')->middleware(['permission:category.create']);

  Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store')->middleware(['permission:category.create']);

  Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->middleware(['permission:category.edit']);

  Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update')->middleware(['permission:category.edit']);

  Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware(['permission:category.delete']);
});
