<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User - Perpustakaan</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DATATABLE CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        /* NAVBAR */
        .navbar-custom {
            position: absolute;
            width: 100%;
            z-index: 100;
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

</body>

</html>
