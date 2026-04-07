<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

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

    public function buku(Request $request)
    {
        $query = \App\Models\Book::query();

        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $buku = $query->get();

        return view('user.buku', compact('buku'));
    }

    public function home()
    {
        $buku = \App\Models\Book::all();

        return view('user.home', compact('buku'));
    }

    public function pinjam($id)
    {
        $buku = Book::findOrFail($id);

        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok habis!');
        }

        // simpan transaksi
        Transaction::create([
            'user_id' => Auth::id(),
            'book_id' => $buku->id,
            'tanggal_pinjam' => now(),
            'tanggal_kembali' => now()->addDays(7),
            'status' => 'dipinjam'
        ]);

        // kurangi stok
        $buku->decrement('stok');

        // redirect ke transaksi
        return redirect('/transaksi')->with('success', 'Buku berhasil dipinjam!');
    }

    public function detail($id)
    {
        $buku = Book::findOrFail($id);

        // cek apakah user sudah pinjam buku ini
        $sudahPinjam = Transaction::where('user_id', Auth::id())
            ->where('book_id', $id)
            ->where('status', 'dipinjam')
            ->exists();

        return view('user.detail', compact('buku', 'sudahPinjam'));
    }

    public function transaksi()
    {
        $transaksi = Transaction::with('book')
            ->where('user_id',  Auth::id())
            ->latest()
            ->get();

        return view('user.transaksi', compact('transaksi'));
    }

    public function bukuSaya()
    {
        $transaksi = Transaction::with('book')
            ->where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->get();

        return view('user.buku_saya', compact('transaksi'));
    }

    public function editTanggal(Request $request, $id)
    {
        $trx = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $trx->tanggal_kembali = $request->tanggal;
        $trx->save();

        return back()->with('success', 'Tanggal kembali berhasil diupdate!');
    }

    public function updateTanggal(Request $request, $id)
    {
        $trx = Transaction::findOrFail($id);

        $trx->update([
            'tanggal_kembali' => $request->tanggal_kembali
        ]);

        return back()->with('success', 'Tanggal kembali berhasil diupdate!');
    }
}
