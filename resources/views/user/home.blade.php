@extends('layouts.user')

@section('content')
    <style>
        .hero {
            background: #3f4366;
            position: relative;
            color: white;
            overflow: hidden;
            padding-top: 120px;
        }

        /* background image */
        .hero::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66') center/cover no-repeat;
            opacity: 0.3;
            top: 0;
            left: 0;
        }

        /* konten */
        .hero-content {
            position: relative;
            z-index: 2;
            padding: 0 80px;
        }

        .hero h1 {
            font-size: 60px;
            font-weight: bold;
        }

        .highlight {
            color: #f4b400;
        }

        .btn-main {
            background: #f4b400;
            border-radius: 30px;
            padding: 10px 25px;
            color: white;
            border: none;
        }

        .video-box {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .video-box iframe {
            width: 100%;
            height: 300px;
        }

        /* WAVE */
        .wave-top {
            position: absolute;
            top: 0;
            width: 100%;
        }

        .wave-bottom {
            width: 100%;
        }

        /* ===== SECTION BUKU ===== */
        .section-buku {
            padding: 80px;
            background: #f8f9fc;
        }

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

        .video-box iframe {
            border-radius: 20px;
            width: 100%;
            height: 300px;
        }

        .img-buku {
            width: 100%;
            height: 200px;
            object-fit: contain;
            background: #f3f4f6;
            padding: 5px;
        }

        .book-card {
            display: inline-block;
            width: auto;
            min-width: 250px;
            max-width: 300px;
        }

        .book-img {
            width: 100%;
            height: 260px;
            /* lebih tinggi biar portrait enak */
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f3f4f6;
            overflow: hidden;
        }

        .book-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* ini wajib */
        }
    </style>

    {{-- HERO --}}
    <div class="hero">

        <svg class="wave-top" viewBox="0 0 1440 200">
            <path fill="#3f4366"
                d="M0,64L80,74.7C160,85,320,107,480,112C640,117,800,107,960,112C1120,117,1280,139,1360,149.3L1440,160L1440,0L0,0Z">
            </path>
        </svg>

        <div class="hero-content">
            <div class="row align-items-center">

                <div class="col-md-6">
                    <h2>Selamat datang di</h2>

                    <h1>
                        Perpustakaan <span class="highlight">Digital</span>
                    </h1>

                    <p>
                        Temukan ribuan buku dan nikmati pengalaman membaca modern
                    </p>

                    <div class="mt-4">
                        <a href="#buku" class="btn btn-main">
                            Jelajahi Buku
                        </a>

                        <a href="/buku-saya" class="btn btn-light ms-2">
                            Buku Saya
                        </a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="video-box">
                        <iframe width="100%" height="300"
                            src="https://www.youtube.com/embed/2dj56Wwz1l0?autoplay=1&mute=1&controls=0" frameborder="0"
                            allow="autoplay; encrypted-media" allowfullscreen>
                        </iframe>
                    </div>
                </div>

            </div>
        </div>

        <svg class="wave-bottom" viewBox="0 0 1440 200">
            <path fill="#ffffff"
                d="M0,128L80,122.7C160,117,320,107,480,96C640,85,800,75,960,85.3C1120,96,1280,128,1360,144L1440,160L1440,320L0,320Z">
            </path>
        </svg>

    </div>

    {{-- ================= BUKU ================= --}}
    <div id="buku" class="section-buku">

        <div class="mb-5">
            <h2 class="fw-bold">📚 Daftar Buku</h2>
            <p>Temukan buku yang ingin kamu pinjam</p>
        </div>

        <div class="row">

            @foreach ($buku as $b)
                <div class="col-auto mb-4">
                    <div class="book-card shadow-sm">

                        @if ($b->image)
                            <img src="{{ asset('storage/' . $b->image) }}"
                                style="width:100%; height:200px; object-fit:contain; background:#f3f4f6;">
                        @else
                            <img src="https://via.placeholder.com/300x200?text=No+Image"
                                style="width:100%; height:200px; object-fit:contain;">
                        @endif

                        <div class="p-3">
                            <h5>{{ $b->judul }}</h5>
                            <p class="text-muted">{{ $b->pengarang }}</p>

                            <p>Stok: <b>{{ $b->stok }}</b></p>

                            <a href="/buku/{{ $b->id }}" class="btn btn-warning">
                                Lihat Detail
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>

    </div>
@endsection
