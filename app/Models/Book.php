<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['judul', 'penulis', 'penerbit', 'tahun', 'kategori', 'stok'];

    public function home()
    {
        $buku = Book::all();

        return view('user.home', compact('buku'));
    }
}
