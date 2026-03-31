<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\TransactionController;
use App\Models\Book;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('books', BookController::class);
});


Route::get('/dashboard', function () {
    $totalBuku = Book::count();
    $totalStok = Book::sum('stok');
    $totalSiswa = User::count();
    $totalDipinjam = 0; // sementara
    $totalKembali = 0; // sementara

    return view('dashboard', compact(
        'totalBuku',
        'totalStok',
        'totalSiswa',
        'totalDipinjam',
        'totalKembali'
    ));
})->middleware(['auth'])->name('dashboard');

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::post('/transactions/kembali/{id}', [TransactionController::class, 'kembali'])->name('transactions.kembali');
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

require __DIR__.'/auth.php';
