<?php

namespace App\Http\Controllers;

use App\Models\Puzzle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PuzzleController extends Controller
{
    public function create()
    {
        return view('puzzles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fen' => 'required|string',
            'plays_first' => 'required|in:white,black',
            'difficulty' => 'required|integer|min:1|max:10',
            'solution' => 'nullable|string',
            'castlingRights' => 'nullable|string',
        ]);

        $puzzle = new Puzzle();
        $puzzle->fen = $validated['fen'];
        $puzzle->plays_first = $validated['plays_first'];
        $puzzle->difficulty = $validated['difficulty'];
        $puzzle->solution = $validated['solution'] ?? null;
        $puzzle->castling_rights = $validated['castlingRights'] ?? '-';
        $puzzle->created_by = auth()->id();

        $puzzle->save();

        return redirect()->back()->with('success', 'Puzzle successfully added!');
    }

    public function play(Request $request)
    {
        $difficulty = $request->input('difficulty');

        $puzzle = Puzzle::where('difficulty', $difficulty)->inRandomOrder()->first();

        if (!$puzzle) {
            return redirect()->route('dashboard')->with('error', 'Nema dostupnih zagonetki za odabranu težinu.');
        }

        $fenPosition = $puzzle->fen;
        $playsFirst = strtolower($puzzle->plays_first) === 'white' ? 'w' : 'b';
        $castling = $puzzle->castling_rights ?: '-';
        $enPassant = '-';
        $halfmoveClock = '0';
        $fullmoveNumber = '1';

        $fullFen = "{$fenPosition} {$playsFirst} {$castling} {$enPassant} {$halfmoveClock} {$fullmoveNumber}";

        return view('puzzles.play', [
            'puzzle' => $puzzle,
            'fen' => $fullFen,
        ]);
    }
}
