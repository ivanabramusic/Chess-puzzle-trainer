<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Puzzle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (auth()->user()->role_id !== 1) {
            abort(403, 'Unauthorized');
        }

        return view('admin.dashboard');
    }


    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function puzzles()
    {
        $puzzles = Puzzle::all();
        return view('admin.puzzles', compact('puzzles'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|integer|in:1,2,3',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    public function updatePuzzle(Request $request, $puzzleId)
    {
        $puzzle = Puzzle::findOrFail($puzzleId);

        $validated = $request->validate([
            'fen' => 'required|string',
            'solution' => 'required|string',
            'difficulty' => 'required|integer|min:1|max:10',
        ]);

        $puzzle->update($validated);

        return redirect()->route('admin.puzzles')->with('success', 'Puzzle updated successfully.');
    }

    public function deletePuzzle(Puzzle $puzzle)
    {
        $puzzle->delete();
        return redirect()->route('admin.puzzles')->with('success', 'Puzzle deleted successfully.');
    }
}
