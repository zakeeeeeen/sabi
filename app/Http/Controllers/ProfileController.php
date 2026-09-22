<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['required', 'in:co,ce'],
        ]);

        $user = Auth::user();
        $user->update($data);

        return redirect()->route('menu');
    }
}
