<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only(['email', 'password']);
        if (Auth::attempt($credentials)) {
            $user = User::firstWhere('email', $request->email);
            $user->connect();
            $user->save();
            $request->session()->regenerate();

            return response()->json(['message' => 'Bienvenue Dans Gesmar !!']);
        } else {
            return response()->json(['message' => 'Adresse ou mot de passe incorrecte', 'credentials' => $credentials], 401);
        }
    }

    /**
     * Undocumented function
     *
     * @param  Request  $request
     * @return void
     */
    public function deconnecter(Request $request): void
    {
        $user = User::findOrFail($request->id);
        $user->disconnect();
        $user->save();
    }

    /**
     * Undocumented function
     *
     * @param  Request  $request
     * @return void
     */
    public function logout(Request $request): void
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function me()
    {
        $user = User::find(Auth::user()->id);
        return UserResource::make($user);
    }
}
