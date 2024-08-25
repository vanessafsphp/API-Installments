<?php

use App\Http\Controllers\CarneController;
use App\Http\Controllers\ParcelaController;
use Illuminate\Support\Facades\Route;

Route::post('/carne', [CarneController::class, 'store']);
Route::get('/carne/{id}/parcelas', [ParcelaController::class, 'buscarParcelas']);
