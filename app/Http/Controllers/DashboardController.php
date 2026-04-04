<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 📊 CARD DATA
        $totalStok = Book::sum('stok');
        $totalSiswa = User::count();
        $totalDipinjam = Transaction::where('status', 'pinjam')->count();
        $totalKembali = Transaction::where('status', 'kembali')->count();

        // 📦 DATA LIST
        $users = User::all();
        $books = Book::all();
        $transactions = Transaction::with('user', 'book')->latest()->get();

        // 📊 CHART (per bulan)
        $chartData = Transaction::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        // Label bulan
        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // Isi data lengkap 12 bulan (biar ga bolong)
        $finalData = [];

        for ($i = 1; $i <= 12; $i++) {
            $finalData[] = $chartData[$i] ?? 0;
        }

        // 📚 TOP BUKU
        $topBooks = Transaction::with('book')
            ->selectRaw('book_id, COUNT(*) as total')
            ->groupBy('book_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(function ($t) {
                return (object)[
                    'judul' => $t->book->judul ?? '-',
                    'total' => $t->total
                ];
            });

        // 👤 SISWA TERAKTIF
        $topUsers = Transaction::with('user')
            ->selectRaw('user_id, COUNT(*) as total')
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(function ($t) {
                return (object)[
                    'name' => $t->user->name ?? '-',
                    'total' => $t->total
                ];
            });

        return view('dashboard', compact(
            'totalStok',
            'totalSiswa',
            'totalDipinjam',
            'totalKembali',
            'users',
            'books',
            'transactions',
            'topBooks',
            'topUsers',
            'chartLabels',
            'finalData'
        ));
    }
}
