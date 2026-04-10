<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User - Perpustakaan</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DATATABLE CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        /* NAVBAR */
        .navbar-custom {
            position: absolute;
            width: 100%;
            z-index: 1000;
            background: transparent;
        }

        .nav-link-custom {
            color: white;
            text-decoration: none;
            font-weight: 500;
            position: relative;
            transition: 0.3s;
        }

        .nav-link-custom:hover {
            color: #f4b400;
        }

        .nav-link-custom::after {
            content: '';
            position: absolute;
            width: 0%;
            height: 2px;
            background: #f4b400;
            left: 0;
            bottom: -5px;
            transition: 0.3s;
        }

        .nav-link-custom:hover::after {
            width: 100%;
        }

        .nav-link-custom.active {
            color: #f4b400;
        }

        .btn-logout {
            border-radius: 30px;
            padding: 5px 15px;
        }

        /* NAVBAR SOLID */
        .navbar-solid {
            background: #3f4366 !important;
            position: relative !important;
        }

        /* SEARCH BOX */
        .search-box {
            width: 260px;
            padding: 10px 15px 10px 40px;
            border-radius: 25px;
            border: none;
            outline: none;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            transition: 0.3s;
        }

        .search-box::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-box:focus {
            width: 300px;
            background: rgba(255, 255, 255, 0.3);
        }

        /* ICON */
        .search-wrapper i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
        }

        /* DROPDOWN */
        .search-result {
            position: absolute;
            top: 45px;
            width: 300px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            display: none;
            z-index: 999;
        }

        /* ITEM */
        .search-item {
            padding: 12px 15px;
            cursor: pointer;
            transition: 0.2s;
        }

        .search-item:hover {
            background: #f3f4f6;
        }

        /* JUDUL */
        .search-item strong {
            font-size: 14px;
            color: #111827;
        }

        /* PENULIS */
        .search-item small {
            color: gray;
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    @if (!request()->is('buku/*'))
        <nav
            class="navbar navbar-expand-lg navbar-dark 
            {{ request()->is('user') ? 'navbar-custom' : 'navbar-solid shadow-sm' }}">

            <div class="container">

                <a class="navbar-brand fw-bold text-white" href="/user">
                    📚 Perpustakaan
                </a>

                <div class="ms-auto d-flex align-items-center gap-4">

                    {{-- SEARCH --}}
                    <div class="search-wrapper">
                       
                        <input type="text" id="searchInput" class="search-box" placeholder="Cari buku...">

                        <div id="searchResult" class="search-result"></div>
                    </div>

                    {{-- DROPDOWN HASIL --}}
                    <div id="searchResult" class="search-result"></div>

                    <a href="/user" class="nav-link-custom {{ request()->is('user') ? 'active' : '' }}">
                        Home
                    </a>

                    <a href="/user#buku" class="nav-link-custom">
                        Buku
                    </a>

                    <a href="/transaksi" class="nav-link-custom {{ request()->is('transaksi') ? 'active' : '' }}">
                        Transaksi
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-outline-light btn-logout">
                            Logout
                        </button>
                    </form>

                </div>
            </div>
        </nav>
    @endif

    {{-- CONTENT --}}
    @yield('content')

    <!-- ================== SCRIPT ================== -->

    <!-- jQuery (WAJIB) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables CORE (WAJIB BANGET) -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Bootstrap -->
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- INIT DATATABLE -->
    <script>
        $(document).ready(function() {
            if ($('#tableTransaksi').length) {
                $('#tableTransaksi').DataTable({
                    pageLength: 5,
                    lengthMenu: [5, 10, 25],
                    dom: '<"d-flex justify-content-between mb-3"lf>rtip',
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        paginate: {
                            previous: "Prev",
                            next: "Next"
                        }
                    }
                });
            }
        });
    </script>

    <script>
        $('#searchInput').on('keyup', function() {
            let query = $(this).val();

            if (query.length < 2) {
                $('#searchResult').hide();
                return;
            }

            $.ajax({
                url: "/search-buku",
                data: {
                    q: query
                },
                success: function(data) {

                    let html = '';

                    data.forEach(buku => {
                        html += `
                    <div class="search-item" onclick="window.location='/buku/${buku.id}'">
                        <strong>${buku.judul}</strong><br>
                        <small>${buku.penulis}</small>
                    </div>
                `;
                    });

                    $('#searchResult').html(html).show();
                }
            });
        });
    </script>

</body>

</html>
