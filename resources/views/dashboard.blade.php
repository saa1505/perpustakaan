<x-app-layout>

    <div class="py-12 min-h-screen bg-gradient-to-br from-slate-100 via-blue-100 to-indigo-200 relative">

        {{--  BACKGROUND BLUR --}}
        <div class="absolute -top-20 -left-20 w-96 h-96 bg-blue-400/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-400/30 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative">

            {{-- welcome --}}
            <div
                class="mb-12 p-8 rounded-3xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white shadow-2xl relative">

                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-purple-300/30 rounded-full blur-2xl"></div>

                <div class="flex flex-col lg:flex-row justify-between items-center gap-6 relative">

                    <div>
                        <h2 class="text-4xl font-semibold tracking-tight">
                            Halo, {{ Auth::user()->name }} 👋
                        </h2>
                        <p class="opacity-80">
                            Selamat datang kembali di dashboard perpustakaan
                        </p>
                        <p class="text-xs opacity-60 mt-1">
                            {{ now()->format('l, d M Y') }}
                        </p>
                    </div>

                    {{-- SEARCH --}}
                    <div class="relative w-full lg:w-1/3 z-10">
                        <span class="absolute left-4 top-3 text-gray-400">🔍</span>

                        <input type="text" id="searchInput" placeholder="Cari sesuatu..."
                            class="w-full pl-10 pr-4 py-3 rounded-2xl bg-white/80 backdrop-blur-lg text-gray-700 shadow-xl border border-white/40 focus:ring-2 focus:ring-white outline-none">

                        <div id="searchResult"
                            class="absolute bg-white/90 backdrop-blur-xl w-full mt-2 rounded-xl shadow-xl hidden z-[999] max-h-60 overflow-y-auto">
                        </div>
                    </div>

                </div>
            </div>

            {{-- 📊 CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">

                @php
                    $cards = [
                        ['title' => 'Total Stok', 'value' => $totalStok, 'icon' => '📚'],
                        ['title' => 'Total Siswa', 'value' => $totalSiswa, 'icon' => '👤'],
                        ['title' => 'Dipinjam', 'value' => $totalDipinjam, 'icon' => '📖'],
                        ['title' => 'Dikembalikan', 'value' => $totalKembali, 'icon' => '✅'],
                    ];
                @endphp

                @foreach ($cards as $c)
                    <div
                        class="p-6 rounded-3xl bg-white/60 backdrop-blur-xl border border-white/30 shadow-lg hover:shadow-2xl hover:scale-[1.02] transition flex justify-between items-center">

                        <div>
                            <h4 class="text-gray-500 text-sm">{{ $c['title'] }}</h4>
                            <p class="text-3xl font-bold text-gray-800">{{ $c['value'] }}</p>
                            <p class="text-xs text-green-500 mt-1">+Update terbaru</p>
                        </div>

                        <div class="text-4xl">{{ $c['icon'] }}</div>

                    </div>
                @endforeach

            </div>

            {{-- CONTENT --}}
            <div class="space-y-8">

                {{-- 🔥 ROW 1: CHART + AKTIVITAS --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- 📊 CHART --}}
                    <div
                        class="lg:col-span-2 p-6 rounded-3xl bg-white/60 backdrop-blur-xl border border-white/30 shadow-lg">
                        <h3 class="font-semibold mb-4 text-gray-700">Statistik Peminjaman (Per Bulan)</h3>
                        <canvas id="chartPeminjaman" height="120"></canvas>
                    </div>

                    {{-- 🧠 AKTIVITAS (KECIL) --}}
                    <div class="p-6 rounded-3xl bg-white/60 backdrop-blur-xl border border-white/30 shadow-lg">
                        <h3 class="font-semibold mb-4 text-gray-700">Aktivitas</h3>

                        <div class="space-y-4 max-h-[300px] overflow-y-auto">

                            @forelse ($transactions->take(5) as $t)
                                <div class="flex items-start gap-3">

                                    <div class="w-2 h-2 mt-2 bg-blue-500 rounded-full"></div>

                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">
                                            {{ $t->user->name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $t->book->judul }}
                                        </p>
                                        <span class="text-xs text-gray-400">
                                            {{ $t->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                </div>
                            @empty
                                <div class="text-gray-400 text-sm">Belum ada aktivitas</div>
                            @endforelse

                        </div>
                    </div>

                </div>

                {{-- 🔥 ROW 2: TOP BUKU + SISWA --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    {{-- 📚 TOP BUKU --}}
                    <div class="p-6 rounded-3xl bg-white/60 backdrop-blur-xl border border-white/30 shadow-lg">
                        <h3 class="font-semibold mb-4 text-gray-700">Top Buku Dipinjam</h3>

                        <div class="space-y-4">

                            @foreach ($topBooks as $book)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-700">{{ $book->judul }}</span>
                                    <span class="text-sm font-bold text-blue-600">{{ $book->total }}</span>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    {{-- 👤 SISWA TERAKTIF --}}
                    <div class="p-6 rounded-3xl bg-white/60 backdrop-blur-xl border border-white/30 shadow-lg">
                        <h3 class="font-semibold mb-4 text-gray-700">Siswa Teraktif</h3>

                        <div class="space-y-4">

                            @foreach ($topUsers as $user)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-700">{{ $user->name }}</span>
                                    <span class="text-sm font-bold text-green-600">{{ $user->total }}</span>
                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    {{-- 🔍 SEARCH SCRIPT --}}
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {

            let keyword = this.value;

            if (keyword.length < 1) {
                document.getElementById('searchResult').classList.add('hidden');
                return;
            }

            fetch(`/search?q=${keyword}`)
                .then(res => res.json())
                .then(data => {

                    let html = '';

                    if (data.length === 0) {
                        html = `<div class="p-3 text-gray-400">Tidak ditemukan</div>`;
                    }

                    data.forEach(item => {
                        html += `
                            <div onclick="
                                if('${item.type}' === 'Buku') {
                                window.location.href='/books?q=${item.name}';
                                    } else if('${item.type}' === 'Anggota') {
                                        window.location.href='/users?q=${item.name}';
                                    } else if('${item.type}' === 'Transaksi') {
                                        window.location.href='/transactions?q=${item.name}';
                                    }"

                                class="p-3 hover:bg-blue-50 transition cursor-pointer border-b">

                                <div class="text-xs text-gray-500">${item.type}</div>
                                <div class="font-semibold text-gray-800">${item.name}</div>
                                <div class="text-xs text-gray-400">${item.detail}</div>

                            </div>
                        `;
                    });

                    let box = document.getElementById('searchResult');
                    box.innerHTML = html;
                    box.classList.remove('hidden');
                });
        });

        document.addEventListener('click', function(e) {
            if (!document.getElementById('searchInput').contains(e.target)) {
                document.getElementById('searchResult').classList.add('hidden');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('chartPeminjaman');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Total Peminjaman',
                    data: {!! json_encode($finalData) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>

</x-app-layout>
