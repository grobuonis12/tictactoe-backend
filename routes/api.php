<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicTacToeController;

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

// Test route
Route::get('test', function () {
    return 'success';
});

// Sanctum routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/make-move', [TicTacToeController::class, 'makeMove']);
    Route::get('/get-action-log', [TicTacToeController::class, 'getActionLog']);
});

