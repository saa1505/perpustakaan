@extends('layouts.user')

@section('content')
    <style>
        .section {
            padding: 100px 80px;
            background: #f8f9fc;
        }

        /* CARD */
        .book-card {
            border-radius: 15px;
            overflow: hidden;
            transition: 0.3s;
            background: white;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .book-img {
            height: 180px;
            background: url('https://images.unsplash.com/photo-1512820790803-83ca734da794') center/cover;
        }

        .btn-main {
            background: #f4b400;
            border-radius: 30px;
            color: white;
        }
    </style>

    <div class="section">

        {{-- TITLE --}}
        <div class="mb-5">
            <h2 class="fw-bold">📚 Daftar Buku</h2>
            <p>Temukan buku yang ingin kamu pinjam</p>
        </div>

        {{-- SEARCH --}}
        <form method="GET" action="/buku" class="mb-4">
            <input type="text" name="search" class="form-control" placeholder="Cari buku...">
        </form>

        <div class="row">

            @foreach ($buku as $b)
                <div class="col-md-4 mb-4">
                    <div class="book-card shadow-sm">

                        @if ($b->image)
                            <img src="{{ asset('storage/' . $b->image) }}"
                                style="width:100%; height:200px; object-fit:cover;">
                        @else
                            <img src="https://via.placeholder.com/300x200?text=No+Image">
                        @endif

                        <div class="p-3">
                            <h5>{{ $b->judul }}</h5>
                            <p class="text-muted">{{ $b->penulis }}</p>

                            <p>Stok: <b>{{ $b->stok }}</b></p>

                            <a href="/pinjam/{{ $b->id }}" class="btn btn-main btn-sm">
                                Pinjam
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>

    </div>
@endsection
