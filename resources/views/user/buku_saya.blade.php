@extends('layouts.user')

@section('content')
    <style>
        .book-cover {
            width: 100%;
            max-width: 200px;
            /* biar gak kegedean */
            aspect-ratio: 2/3;
            margin: 20px auto 10px;
            overflow: hidden;
            border-radius: 12px;
            background: #f3f4f6;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* sekarang aman karena container udah pas */
        }

        .card {
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-body {
            text-align: center;
        }
    </style>
@section('content')
    <div class="container mt-5">

        <h3 class="fw-bold mb-4">📚 Buku Saya</h3>

        <div class="row">

            @foreach ($transaksi as $trx)
                <div class="col-md-4 mb-4">

                    <div class="card shadow-lg border-0 rounded-4 h-100">

                        @if ($trx->book && $trx->book->image)
                            <div class="book-cover">
                                <img src="{{ asset('storage/' . $trx->book->image) }}">
                            </div>
                        @else
                            <div class="book-cover">
                                <img src="https://via.placeholder.com/300x450?text=No+Image">
                            </div>
                        @endif

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
                            <a href="/baca/{{ $trx->book->id }}" class="btn btn-warning w-100 rounded-pill">
                                📖 Baca Buku
                            </a>

                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    </div>
@endsection
