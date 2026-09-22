<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if ($request->filled('name')) {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:50'],
                'avatar' => ['nullable', 'string', 'in:co,ce'],
            ]);

            $name = trim($data['name']);
            $avatar = $data['avatar'] ?? 'co';

            $user = User::where('name', $name)->first();
            if (! $user) {
                $baseEmail = strtolower(preg_replace('/[^a-z0-9]/', '', $name));
                if (empty($baseEmail)) {
                    $baseEmail = 'pengusaha';
                }
                $email = $baseEmail.'_'.time().'@sabi.local';

                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => bcrypt('sabi123'),
                    'avatar' => $avatar,
                ]);
            } else {
                if (! empty($avatar)) {
                    $user->update(['avatar' => $avatar]);
                }
            }

            Auth::login($user, true);
            $request->session()->regenerate();

            return redirect()->intended(route('menu'));
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password salah.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('menu'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $data['avatar'] = 'co';

        $user = User::create($data);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('menu');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/');
    }
}
