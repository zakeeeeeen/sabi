<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! $user->is_admin || ! Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password admin salah.']);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }
}
