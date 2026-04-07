<nav class="navbar navbar-expand-lg navbar-dark"
    style="position:absolute; width:100%; z-index:100; background:transparent;">

    <div class="container">

        {{-- LOGO --}}
        <a class="navbar-brand fw-bold text-white" href="/user">
            📚 Perpustakaan
        </a>

        {{-- MENU --}}
        <div class="ms-auto d-flex align-items-center gap-4">

            <a href="/user" class="nav-link-custom {{ request()->is('user') ? 'active' : '' }}">
                Home
            </a>

            <a href="/user#buku" class="nav-link-custom {{ request()->is('buku') ? 'active' : '' }}">
                Buku
            </a>

            <a href="/transaksi" class="nav-link-custom {{ request()->is('transaksi') ? 'active' : '' }}">
                Transaksi
            </a>

            {{-- LOGOUT --}}
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-outline-light rounded-pill px-3">
                    Logout
                </button>
            </form>

        </div>
    </div>
</nav>
