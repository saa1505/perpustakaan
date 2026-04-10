@extends('layouts.user')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
        }

        /* container */
        .baca-container {
            max-width: 800px;
            margin: 120px auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
        }

        /* judul */
        .baca-title {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* penulis */
        .baca-author {
            color: gray;
            margin-bottom: 20px;
        }

        /* isi cerita */
        .baca-content {
            line-height: 1.8;
            text-align: justify;
            font-size: 16px;
            color: #374151;
        }

        /* tombol */
        .btn-kembali {
            margin-top: 30px;
        }

        img:hover {
            transform: scale(1.02);
        }

        .img-buku {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: contain;
        }

        .img-buku:hover {
            transform: scale(1.03);
        }

        .baca-container {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="container mt-5">

        <div class="row align-items-start">

            {{-- GAMBAR KIRI --}}
            <div class="col-md-5">
                @if ($buku->image)
                    <img src="{{ asset('storage/' . $buku->image) }}" class="img-buku">
                @else
                    <img src="https://via.placeholder.com/400x500?text=No+Image" class="img-buku">
                @endif
            </div>

            {{-- KONTEN KANAN --}}
            <div class="col-md-7">
                <div class="baca-container">

                    <div class="baca-title">
                        {{ $buku->judul }}
                    </div>

                    <div class="baca-author">
                        ✍️ {{ $buku->penulis }}
                    </div>

                    <hr>

                    <div class="baca-content">
                        {!! nl2br(e($buku->deskripsi_full ?: $buku->deskripsi ?: 'Belum ada cerita.')) !!}
                    </div>

                    <a href="/buku-saya" class="btn btn-secondary btn-kembali">
                        ⬅ Kembali
                    </a>

                </div>
            </div>

        </div>

    </div>
@endsection
