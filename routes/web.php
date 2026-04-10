<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Models\Book;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/user', function () {
    return view('user.home');
})->middleware('auth');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login'); // ⬅️ ini yang penting
})->name('logout');

Route::get('/search', function (Illuminate\Http\Request $request) {

    $q = $request->q;

    $users = User::where('name', 'like', "%$q%")
        ->orWhere('email', 'like', "%$q%")
        ->orWhereRaw("'anggota' LIKE ?", ["%$q%"])
        ->get()
        ->map(function ($u) {
            return [
                'type' => 'Anggota',
                'name' => $u->name,
                'detail' => $u->email
            ];
        });

    $books = Book::where('judul', 'like', "%$q%")
        ->orWhere('penulis', 'like', "%$q%")
        ->orWhere('kategori', 'like', "%$q%")
        ->orWhereRaw("'buku' LIKE ?", ["%$q%"])
        ->get()
        ->map(function ($b) {
            return [
                'type' => 'Buku',
                'name' => $b->judul,
                'detail' => $b->penulis
            ];
        });

    $transactions = Transaction::with('user', 'book')
        ->where('kondisi', 'like', "%$q%")
        ->orWhereRaw("'transaksi' LIKE ?", ["%$q%"])
        ->get()
        ->map(function ($t) {
            return [
                'type' => 'Transaksi',
                'name' => $t->user->name,
                'detail' => $t->book->judul . ' (' . ($t->kondisi ?? '-') . ')'
            ];
        });

    return response()->json(
        $users
            ->concat($books)
            ->concat($transactions)
            ->values()
    );
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('books', BookController::class);
});


Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::post('/transactions/kembali/{id}', [TransactionController::class, 'kembali'])->name('transactions.kembali');
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

Route::resource('users', UserController::class);

Route::get('/laporan', [App\Http\Controllers\ReportController::class, 'index'])->name('laporan.index');
Route::get('/laporan/pdf', [ReportController::class, 'exportPdf'])->name('laporan.pdf');
Route::get('/laporan/print', [ReportController::class, 'print'])->name('laporan.print');

Route::get('/buku', [UserController::class, 'buku'])->middleware('auth');
Route::post('/pinjam/{id}', [UserController::class, 'pinjam'])->name('pinjam');
Route::get('/transaksi', [UserController::class, 'transaksi']);

Route::get('/user', function () {
    $buku = Book::all(); // ambil data buku

    return view('user.home', compact('buku'));
})->middleware('auth');

Route::get('/buku/{id}', [UserController::class, 'detail']);
Route::get('/buku-saya', [UserController::class, 'bukuSaya']);
Route::get('/transaksi/edit/{id}', [UserController::class, 'editTanggal']);
Route::post('/transaksi/edit/{id}', [UserController::class, 'updateTanggal']);

Route::get('/baca/{id}', [UserController::class, 'baca'])->name('baca.buku');

Route::put('/transactions/{id}', [UserController::class, 'updateTransaksi']);
Route::delete('/transaksi/delete/{id}', [UserController::class, 'destroyTransaksi']);
Route::post('/admin/confirm/{id}', [TransactionController::class, 'confirm']);

Route::get('/search-buku', function (Illuminate\Http\Request $request) {
    return \App\Models\Book::where('judul', 'like', '%' . $request->q . '%')
        ->take(5)
        ->get();
});

require __DIR__ . '/auth.php';
