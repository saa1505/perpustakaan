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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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


require __DIR__ . '/auth.php';
