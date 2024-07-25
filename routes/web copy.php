<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UjiController;

Route::get('/input-form', [UjiController::class, 'showInputForm'])->name('inputForm');
Route::get('/getProductData', [UjiController::class, 'getProductData'])->name('getProductData');
Route::post('/validate-data', [UjiController::class, 'validateData'])->name('validateData');
