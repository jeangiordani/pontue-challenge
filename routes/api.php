<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'auth'], function ($router) {

    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('jwt.auth');
    Route::post('/user', [AuthController::class, 'user'])->name('auth.user')->middleware('jwt.auth');
    Route::post('/register', [UserController::class, 'createUser'])->name('register.user');
});

Route::get('/users', [UserController::class, 'getAllUsers'])->name('get.users')->middleware('jwt.auth');
Route::get('/users/{id}', [UserController::class, 'getUser'])->name('get.user')->middleware('jwt.auth');
Route::put('/users/{id}', [UserController::class, 'updateUser'])->name('update.user')->middleware('jwt.auth');
Route::delete('/users/{id}', [UserController::class, 'destroyUser'])->name('delete.user')->middleware('jwt.auth');
