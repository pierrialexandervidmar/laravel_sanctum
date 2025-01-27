<?php

use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Services\ApiResponse;

Route::get('/status', function(){
    return ApiResponse::success('API is running bixo!');
});

// Autenticação
Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('clients', ClientController::class);


