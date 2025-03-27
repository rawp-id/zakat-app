<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        Auth::user()->is_admin || Auth::user()->master ? : abort(403);
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'is_admin' => 'required|boolean',
            'master' => 'required|boolean',
        ]);

        $user->update([
            'is_admin' => $request->is_admin,
            'master' => $request->master,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
}
