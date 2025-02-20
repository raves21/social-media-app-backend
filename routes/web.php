<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ["message" => "welcome"];
});

Route::post('/login', [AuthController::class, 'login']);
