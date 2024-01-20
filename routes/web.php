<?php

use App\Http\Controllers\TicTacToeController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/make-move', [TicTacToeController::class, 'makeMove']);
Route::get('/get-action-log', [TicTacToeController::class, 'getActionLog']);
Route::get('/get-board', [TicTacToeController::class, 'getBoard']);
