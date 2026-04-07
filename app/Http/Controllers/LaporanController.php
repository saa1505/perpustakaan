<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
   public function print()
    {
        $transactions = Transaction::with('user', 'book')
                        ->where('status', 'pinjam')
                        ->get();

        return view('laporan.print', compact('transactions'));
    }
}
