<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->as('v1:')->group(function() {
    include base_path('routes/api/v1/routes.php');
});

Route::prefix('v2')->as('v2:')->group(function() {
    include base_path('routes/api/v2/routes.php');
});