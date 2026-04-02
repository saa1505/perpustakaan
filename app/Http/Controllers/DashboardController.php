<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStok = Book::sum('stok');
        $totalSiswa = User::count(); // INI YANG KURANG
        $totalDipinjam = Transaction::where('status', 'pinjam')->count();
        $totalKembali = Transaction::where('status', 'kembali')->count();

        $users = User::all();
        $books = Book::all();
        $transactions = Transaction::with('user', 'book')->get();

        return view('dashboard', compact(
            'totalStok',
            'totalSiswa',
            'totalDipinjam',
            'totalKembali',
            'users',
            'books',
            'transactions'
        ));
    }
}
