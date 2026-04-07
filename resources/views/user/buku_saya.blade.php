@extends('layouts.user')

@section('content')
    <div class="container mt-5">

        <h3 class="fw-bold mb-4">📚 Buku Saya</h3>

        <div class="row">

            @foreach ($transaksi as $trx)
                <div class="col-md-4 mb-4">

                    <div class="card shadow-lg border-0 rounded-4 h-100">

                        {{-- GAMBAR --}}
                        <img src="https://images.unsplash.com/photo-1495446815901-a7297e633e8d" class="card-img-top"
                            style="height:200px; object-fit:cover; border-radius: 15px 15px 0 0;">

                        <div class="card-body">

                            {{-- JUDUL --}}
                            <h5 class="fw-bold">
                                {{ $trx->book->judul }}
                            </h5>

                            {{-- DESKRIPSI FULL --}}
                            <p class="text-muted">
                                {{ Str::limit($trx->book->deskripsi_full, 100) }}
                            </p>

                            {{-- BUTTON --}}
                            <a href="/buku/{{ $trx->book->id }}" class="btn btn-warning w-100 rounded-pill">
                                📖 Baca Buku
                            </a>

                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    </div>
@endsection
