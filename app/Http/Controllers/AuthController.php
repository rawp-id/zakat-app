<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        $user = Socialite::driver('google')->user();
        // dd($user);
        $user = User::firstOrCreate([
            'email' => $user->email
        ], [
            'google_id' => $user->id,
            'name' => $user->name,
        ]);

        Auth::login($user, true);

        return redirect(route('zakats.create'));
    }
}
