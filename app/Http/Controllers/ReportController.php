<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('user', 'book');

        // FILTER TANGGAL
        if ($request->from && $request->to) {
            $query->whereBetween('tanggal_pinjam', [$request->from, $request->to]);
        }

        $transactions = $query->latest()->get();

        // TOTAL DENDA
        $totalDenda = $transactions->sum('denda');

        return view('laporan.index', compact('transactions', 'totalDenda'));
    }

    public function exportPdf()
    {
        $transactions = Transaction::with('user', 'book')
                        ->where('status', 'pinjam')
                        ->get();

        $pdf = Pdf::loadView('laporan/pdf', compact('transactions'));

        return $pdf->download('laporan-peminjaman.pdf');
    }

    public function print()
    {
        $transactions = Transaction::with('user', 'book')
                        ->where('status', 'pinjam')
                        ->get();

        return view('laporan.print', compact('transactions'));
    }
}
