<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password') // default
        ]);

        return back()->with('success', 'Anggota berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return back()->with('success', 'Anggota berhasil diupdate');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return back()->with('success', 'Anggota dihapus');
    }
}
