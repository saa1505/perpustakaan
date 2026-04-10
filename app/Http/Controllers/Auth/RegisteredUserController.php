<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        // ✅ VALIDASI
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,user'], // ✅ TAMBAH ROLE
        ]);

        // ✅ SIMPAN USER + ROLE
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role, // 🔥 INI YANG PENTING
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // ❌ JANGAN AUTO LOGIN
        return redirect()->route('login')->with('success', 'Register berhasil, silakan login!');
    }
}
