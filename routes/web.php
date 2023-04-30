<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaizenController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SignatureController;

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

Route::get('/', [KaizenController::class, 'create'])->name('kaizens.form');
Route::get('/sign/{signature}', SignatureController::class)->name('signatures.show');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/permissions', PermissionController::class)->name('permissions.index')->middleware(['permission:permission.index']);
});

require __DIR__ . '/Features/role.php';
require __DIR__ . '/Features/user.php';
require __DIR__ . '/Features/departement.php';
require __DIR__ . '/Features/category.php';
require __DIR__ . '/Features/kaizen.php';
