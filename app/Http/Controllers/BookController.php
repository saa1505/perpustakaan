<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('books', 'public');
        } else {
            $image = null;
        }

        Book::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun' => $request->tahun,
            'kategori' => $request->kategori,
            'stok' => $request->stok,
            'sinopsis' => $request->sinopsis ?? $request->deskripsi,
            'deskripsi_full' => $request->deskripsi_full ?? $request->deskripsi,
            'image' => $image,
        ]);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('books', 'public');
        } else {
            $image = $book->image;
        }

        $book->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun' => $request->tahun,
            'kategori' => $request->kategori,
            'stok' => $request->stok,
            'sinopsis' => $request->sinopsis ?? $request->deskripsi,
            'deskripsi_full' => $request->deskripsi_full ?? $request->deskripsi,
            'image' => $image,

        ]);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil dihapus!');
    }
}
