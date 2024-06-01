<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Rota pública
Route::post('/login', [LoginController::class, 'login'])->name('login');  // POST - http://127.0.0.1:8000/api/login

// Rota restrita
Route::group(['middleware' => ['auth:sanctum']], function(){

    Route::get('/user', [UserController::class, 'index']); // GET - http://127.0.0.1:8000/api/user?page=1
    Route::get('/user/{user}', [UserController::class, 'show']); // GET - http://127.0.0.1:8000/api/user/2
    Route::post('/user', [UserController::class, 'store']);  // POST - http://127.0.0.1:8000/api/user
    Route::put('/user/{user}', [UserController::class, 'update']); // PUT - http://127.0.0.1:8000/api/user/2
    Route::put('/user-password/{user}', [UserController::class, 'updatePassword']); // PUT - http://127.0.0.1:8000/api/user-password/2
    Route::delete('/user/{user}', [UserController::class, 'destroy']); // DELETE - http://127.0.0.1:8000/api/user/2

});
