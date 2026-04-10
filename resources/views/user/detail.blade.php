@extends('layouts.user')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
            font-family: 'Segoe UI', sans-serif;
        }

        /* container utama */
        .detail-container {
            max-width: 950px;
            margin: 120px auto;
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
        }

        /* gambar */
        .detail-img {
            width: 100%;
            border-radius: 15px;
            object-fit: cover;
            transition: 0.3s;
        }

        .detail-img:hover {
            transform: scale(1.03);
        }

        /* judul */
        .detail-title {
            font-size: 32px;
            font-weight: 700;
        }

        /* penulis */
        .detail-author {
            color: #6b7280;
            margin-bottom: 10px;
        }

        /* rating */
        .rating {
            color: #fbbf24;
            font-size: 20px;
            margin-bottom: 10px;
        }

        /* deskripsi */
        .detail-desc {
            margin-top: 10px;
            color: #4b5563;
            line-height: 1.6;
        }

        /* stok */
        .detail-stock {
            margin-top: 10px;
            font-weight: 600;
        }

        /* tombol pinjam */
        .btn-pinjam {
            background: linear-gradient(135deg, #facc15, #f59e0b);
            border-radius: 30px;
            padding: 12px 28px;
            border: none;
            color: white;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-pinjam:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        /* tombol kembali */
        .btn-kembali {
            border-radius: 30px;
            padding: 12px 28px;
            background: #e5e7eb;
            border: none;
        }

        .btn-kembali:hover {
            background: #d1d5db;
        }
    </style>

    <div class="container">

        <div class="detail-container">

            <div class="row align-items-center">

                @if ($buku->image)
                    <img src="{{ asset('storage/' . $buku->image) }}" style="width:100%; height:200px; object-fit:cover;">
                @else
                    <img src="https://via.placeholder.com/300x200?text=No+Image">
                @endif

                {{-- DETAIL --}}
                <div class="col-md-7">

                    {{-- JUDUL --}}
                    <div class="detail-title">
                        {{ $buku->judul }}
                    </div>

                    {{-- PENULIS --}}
                    <div class="detail-author">
                        {{ $buku->penulis }}
                    </div>

                    {{-- ⭐ RATING --}}
                    <div class="rating">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= ($buku->rating ?? 4))
                                ⭐
                            @else
                                ☆
                            @endif
                        @endfor
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="detail-desc">

                        @if ($buku->deskripsi)
                            <p>
                                {{ $buku->deskripsi }}
                            </p>
                        @else
                            <p>
                                Buku ini menceritakan kisah menarik yang bisa kamu baca setelah meminjam buku ini.
                            </p>
                        @endif

                        @if (!$sudahPinjam)
                            <div class="text-danger mt-2">
                                📌 Pinjam buku untuk membaca cerita lengkap
                            </div>
                        @endif

                    </div>

                    {{-- STOK --}}
                    <div class="detail-stock">
                        Stok: {{ $buku->stok }}
                    </div>

                    {{-- BUTTON --}}
                    <div class="mt-4 d-flex gap-3">

                        {{-- PINJAM --}}
                        <form action="/pinjam/{{ $buku->id }}" method="POST"
                            onsubmit="return confirm('Yakin mau pinjam buku ini?')">
                            @csrf
                            <button class="btn btn-pinjam">
                                📚 Pinjam
                            </button>
                        </form>

                        {{-- KEMBALI --}}
                        <a href="/user#buku" class="btn btn-kembali">
                            ⬅ Kembali
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
