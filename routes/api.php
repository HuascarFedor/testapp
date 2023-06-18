<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index');
    Route::post('users', 'store');
    Route::get('/users/{user}', 'show');
    Route::put('/users/{user}', 'update');
    Route::delete('/users/{user}', 'destroy');

    Route::post('/users/{user}/attach/jobs', 'attach');
    Route::post('/users/{user}/detach/jobs', 'detach');
});

Route::controller(JobController::class)->group(function () {
    Route::get('/jobs', 'index');
    Route::post('jobs', 'store');
    Route::get('/jobs/{job}', 'show');
    Route::put('/jobs/{job}', 'update');
    Route::delete('/jobs/{job}', 'destroy');
});
