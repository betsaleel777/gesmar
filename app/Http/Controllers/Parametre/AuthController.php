<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

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
            Session::put('user', $user);
            return redirect('/')->with('success', 'Bienvenue dans Gesmar, gestion digital de marché');
        }
        return redirect()->route('login')->with('error', 'Les informations de connections ne sont pas valides');
    }

    public function logout()
    {
        $user = User::find(session('user')->id);
        $user->deconnecter();
        $user->save();
        Session::flush();
        Auth::logout();
        return redirect('login');
    }
}
