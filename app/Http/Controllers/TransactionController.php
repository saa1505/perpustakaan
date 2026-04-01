<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Book;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user', 'book')->get();
        $users = User::all();
        $books = Book::all();

        return view('transactions.index', compact('transactions', 'users', 'books'));
    }

    public function store(Request $request)
    {
        Transaction::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'pinjam'
        ]);

        return back()->with('success', 'Buku berhasil dipinjam!');
    }

    public function kembali(Request $request, $id)
    {
        $trx = Transaction::findOrFail($id);

        $today = now();
        $batas = Carbon::parse($trx->tanggal_kembali);

        $denda = 0;

        //  DENDA TERLAMBAT
        if ($today > $batas) {
            $hariTelat = $today->diffInDays($batas);
            $denda += $hariTelat * 2000;
        }

        //  DENDA KERUSAKAN
        if ($request->kondisi == 'rusak' || $request->kondisi == 'hilang'  || $request->kondisi == 'kotor') {
            $denda += 120000;
        }

        $trx->update([
            'status' => 'kembali',
            'denda' => $denda,
            'kondisi' => $request->kondisi
        ]);

        return back()->with('success', 'Buku dikembalikan. Denda: Rp ' . number_format($denda));
    }

    public function destroy($id)
    {
        $trx = Transaction::findOrFail($id);
        $trx->delete();

        return back()->with('success', 'Data transaksi berhasil dihapus');
    }
}
