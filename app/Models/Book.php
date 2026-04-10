<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['image', 'judul', 'penulis', 'penerbit', 'tahun', 'kategori', 'stok', 'deskripsi'];

    public function home()
    {
        $buku = Book::all();

        return view('user.home', compact('buku'));
    }
}
