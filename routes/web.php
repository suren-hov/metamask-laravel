<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web3LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/web3-login-message', [Web3LoginController::class, 'message']);
Route::post('/web3-login-verify', [Web3LoginController::class, 'verify']);
