<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaizenController;

Route::post('/', [KaizenController::class, 'store'])->middleware('throttle:kaizens.store')->name('kaizens.store');
Route::get('/details/{kaizen}', [KaizenController::class, 'showGuest'])->name('kaizens.details');
Route::get('/print/{kaizen}', [KaizenController::class, 'printPDF'])->name('kaizens.print');

Route::middleware('auth')->prefix('admin')->group(function () {
  Route::get('/kaizens', [KaizenController::class, 'index'])->name('kaizens.index')->middleware(['permission:kaizen.index']);

  Route::get('/kaizens/{kaizen}', [KaizenController::class, 'show'])->name('kaizens.show')->middleware(['permission:kaizen.show']);

  Route::get('/kaizens/{kaizen}/pic', [KaizenController::class, 'signPIC'])->name('kaizens.pic')->middleware(['permission:kaizen.pic']);

  Route::get('/kaizens/{kaizen}/secretary', [KaizenController::class, 'signSecretary'])->name('kaizens.secretary')->middleware(['permission:kaizen.secretary']);

  Route::put('/kaizens/{kaizen}/pic', [KaizenController::class, 'updateSignPIC'])->name('kaizens.update.pic')->middleware(['permission:kaizen.pic']);

  Route::put('/kaizens/{kaizen}/secretary', [KaizenController::class, 'updateSignSecretary'])->name('kaizens.update.secretary')->middleware(['permission:kaizen.secretary']);

  Route::delete('/kaizens/{kaizen}', [KaizenController::class, 'destroy'])->name('kaizens.destroy')->middleware(['permission:kaizen.delete']);
});
