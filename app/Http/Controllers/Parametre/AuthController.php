<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $user->connecter();
            $user->save();
            $request->session()->regenerate();
        } else {
            return response()->json(['message' => 'Invalid login details', 'credentials' => $credentials], 401);
        }
    }

    public function deconnecter(Request $request)
    {
        $user = User::find($request->id);
        $user->deconnecter();
        $user->save();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
