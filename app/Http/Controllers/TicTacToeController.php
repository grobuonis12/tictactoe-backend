<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController; // Import the BaseController class
use Illuminate\Support\Facades\DB;
use App\Models\Game;
use App\Models\GameMove;

class TicTacToeController extends BaseController // Extend BaseController
{
    public function makeMove(Request $request)
    {
        // Validate the request
        $request->validate([
            'row' => 'required|integer',
            'col' => 'required|integer',
            'player' => 'required|string|in:X,O',
            'board' => 'required|array', // Add validation for the board
        ]);
    
        // Handle the move logic and update the action log
        $row = $request->input('row');
        $col = $request->input('col');
        $player = $request->input('player');
        $board = $request->input('board');
    
        // Check if the gameId is provided in the request
        $gameId = $request->input('gameId');
    
        // Retrieve the game or create a new one if it doesn't exist
        $game = $gameId ? Game::find($gameId) : Game::create();
    
        // Check if the cell is empty
        if (GameMove::where(['game_id' => $game->id, 'row' => $row, 'col' => $col])->exists()) {
            // Cell is already occupied, return an error response
            return response()->json(['error' => 'Cell is already occupied']);
        }
    
        // Update the board with the player's move
        GameMove::create([
            'game_id' => $game->id,
            'player' => $player,
            'row' => $row,
            'col' => $col,
        ]);
    
        // Set the current player for the next move
        $this->currentPlayer = $player === 'X' ? 'O' : 'X';
    
        // Check for a winner or tie
        $winner = $this->checkWinner($game);
        $tie = $this->checkTie($game);
    
        return response()->json(['success' => true, 'game' => $game, 'winner' => $winner, 'tie' => $tie]);
    }
public function getBoard(Request $request)
{
    $gameId = $request->input('gameId');
    $gameMoves = GameMove::where('game_id', $gameId)->get();

    // Build the board based on game moves
    $board = $this->buildBoard($gameMoves);

    return response()->json(['success' => true, 'board' => $board]);
}


    /**
     * Check if there is a winner in the Tic Tac Toe game.
     *
     * @param Game $game
     * @return string|null
     */
    protected function checkWinner($game)
    {
        $gameMoves = GameMove::where('game_id', $game->id)->get();
    $board = $this->buildBoard($gameMoves);

        // Logic to check for a winner

        // Check rows
        for ($i = 0; $i < 3; $i++) {
            if (
                $board[$i][0] === $this->currentPlayer &&
                $board[$i][1] === $this->currentPlayer &&
                $board[$i][2] === $this->currentPlayer
            ) {
                return $this->currentPlayer;
            }
        }
        
        for ($i = 0; $i < 3; $i++) {
            if (
                $board[0][$i] === $this->currentPlayer &&
                $board[1][$i] === $this->currentPlayer &&
                $board[2][$i] === $this->currentPlayer
            ) {
                return $this->currentPlayer;
            }
        }
        
        if (
            $board[0][0] === $this->currentPlayer &&
            $board[1][1] === $this->currentPlayer &&
            $board[2][2] === $this->currentPlayer
        ) {
            return $this->currentPlayer;
        }
        
        if (
            $board[0][2] === $this->currentPlayer &&
            $board[1][1] === $this->currentPlayer &&
            $board[2][0] === $this->currentPlayer
        ) {
            return $this->currentPlayer;
        }
        return null;
    }

    /**
     * Check if the Tic Tac Toe game is a tie.
     *
     * @param Game $game
     * @return bool
     */
    protected function checkTie($game)
    {
        // Get total number of moves
        $totalMoves = GameMove::where('game_id', $game->id)->count();

        // Check if the game is a tie
        $isTie = $totalMoves === 9; // Assuming a 3x3 grid

        // If the game is not a tie, check if there is a winner
        if (!$isTie) {
            $winner = $this->checkWinner($game);
            // The game is a tie only if there is no winner
            $isTie = $winner === null;
        }

        return $isTie;
    }

    protected function buildBoard($gameMoves)
    {
        // Logic to build the board based on game moves
        $board = [
            ['', '', ''],
            ['', '', ''],
            ['', '', ''],
        ];

        foreach ($gameMoves as $move) {
            $board[$move->row][$move->col] = $move->player;
        }

        return $board;
    }
}
