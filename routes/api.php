<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::post('/order', [OrderController::class, 'create'])->middleware('auth:sanctum');
