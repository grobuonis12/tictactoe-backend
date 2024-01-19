<?php

namespace App\Http\Controllers;

use App\Models\ActionLog;
use Illuminate\Http\Request;

class TicTacToeController extends Controller
{
    public function makeMove(Request $request)
    {
        // Validate the request
        $request->validate([
            'row' => 'required|integer|between:0,2',
            'col' => 'required|integer|between:0,2',
            'player' => 'required|string|in:X,O',
        ]);

        // Save the move to the database
        $logEntry = "Player {$request->input('player')} made a move at ({$request->input('row')}, {$request->input('col')})";
        ActionLog::create(['action' => $logEntry]);

        return response()->json(['message' => 'Move saved successfully']);
    }

    public function getActionLog()
    {
        $log = ActionLog::latest()->get(['action']);
        return response()->json($log);
    }
}
