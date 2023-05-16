<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/currency-converter');

Route::prefix('/currency-converter')->group(function () {
    Route::get('', [HomeController::class, 'index'])->name('index');
    Route::post('', [HomeController::class, 'buy'])->name('buy');
    Route::post('/calculate', [HomeController::class, 'calculate'])->name('calculate');
});
