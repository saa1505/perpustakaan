<x-app-layout>
    <style>
        /* --- TAMPILAN DASHBOARD (LAYAR MONITOR) --- */
        @media screen {
            .container-print {
                display: none; /* Sembunyikan versi print di layar */
            }
        }

        /* --- TAMPILAN PREVIEW PRINT (YANG KAMU MAU) --- */
        @media print {
            /* 1. Sembunyikan elemen UI Dashboard */
            .p-6, .no-print, nav, footer, aside, .sidebar {
                display: none !important;
            }

            @page {
                size: portrait;
                margin: 0; 
            }

            body {
                background-color: #f0f2f5 !important; /* Background abu-abu luar */
                display: flex !important;
                justify-content: center;
                padding: 40px 0 !important;
                -webkit-print-color-adjust: exact;
            }

            /* 2. Kotakan Putih (Dikecilkan Lebarnya) */
            .container-print {
                display: block !important;
                width: 150mm !important; /* LEBIH RAMPING: Sesuaikan ke 140mm jika masih kurang kecil */
                margin: 0 auto;
                background: white !important;
                padding: 15mm;
                border: 1px solid #d1d5db;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                min-height: 240mm;
                font-family: 'Arial', sans-serif;
            }

            /* 3. Perkecil Ukuran Font & Tabel */
            .container-print h3 {
                text-align: center;
                text-transform: uppercase;
                font-size: 16px;
                margin-bottom: 20px;
                color: #111;
            }

            .table-print {
                width: 100% !important;
                border-collapse: collapse;
                border: 1.5px solid #000 !important;
            }

            .table-print th, .table-print td {
                border: 1px solid #000 !important;
                padding: 8px;
                font-size: 11px; /* Font lebih kecil */
                text-align: center;
            }

            .table-print th {
                background-color: #f3f4f6 !important;
                font-weight: bold;
            }
        }
    </style>

    {{-- BAGIAN 1: DASHBOARD INDEX (Tampilan Web Biasa) --}}
    <div class="p-6 bg-gradient-to-br from-indigo-50 via-white to-blue-50 min-h-screen">
        
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">
            📚 Laporan Peminjaman
        </h2>

        {{-- FILTER --}}
        <form method="GET" class="mb-5 flex gap-3 items-center no-print">
            <input type="date" name="from" value="{{ request('from') }}" class="rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500">
            <input type="date" name="to" value="{{ request('to') }}" class="rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500">
            <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg shadow hover:bg-indigo-700 transition">
                Filter
            </button>
        </form>

        {{-- CARD UTAMA --}}
        <div class="bg-white/70 backdrop-blur-xl px-6 py-5 rounded-3xl shadow-lg border border-white/20">
            <div class="flex justify-between items-center mb-6">
                <div class="flex gap-3">
                    <a href="{{ route('laporan.pdf') }}" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600 flex items-center gap-2">
                        <span>📄</span> Export PDF
                    </a>
                    <button onclick="window.print()" class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 flex items-center gap-2">
                        <span>🖨️</span> Print Preview
                    </button>
                </div>
                
                <div class="text-right">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Total Denda Keseluruhan</p>
                    <p class="text-xl font-bold text-red-600">
                        Rp {{ number_format($totalDenda, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="p-4 rounded-tl-xl">Siswa</th>
                            <th class="p-4">Buku</th>
                            <th class="p-4 text-center">Tanggal Pinjam - Kembali</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4 text-right rounded-tr-xl">Denda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($transactions as $t)
                            <tr class="hover:bg-indigo-50/50 transition">
                                <td class="p-4 font-medium text-gray-700">{{ $t->user->name }}</td>
                                <td class="p-4 text-gray-600">{{ $t->book->judul }}</td>
                                <td class="p-4 text-center text-gray-500">
                                    {{ $t->tanggal_pinjam }} <span class="mx-1">→</span> {{ $t->tanggal_kembali }}
                                </td>
                                <td class="p-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $t->status == 'kembali' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                        {{ strtoupper($t->status) }}
                                    </span>
                                </td>
                                <td class="p-4 text-right font-bold text-red-500">
                                    Rp {{ number_format($t->denda, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- BAGIAN 2: KONTEN KHUSUS PRINT (Kotakan Kecil di Tengah) --}}
    <div class="container-print">
        <h3>Laporan Peminjaman Buku</h3>
        
        <table class="table-print">
            <thead>
                <tr>
                    <th>Siswa</th>
                    <th>Buku</th>
                    <th>Periode Pinjam</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $t)
                    <tr>
                        <td>{{ $t->user->name }}</td>
                        <td>{{ $t->book->judul }}</td>
                        <td>{{ $t->tanggal_pinjam }} s/d {{ $t->tanggal_kembali }}</td>
                        <td>{{ $t->status }}</td>
                        <td>Rp {{ number_format($t->denda, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold; padding: 10px;">Total Denda:</td>
                    <td style="font-weight: bold; color: red;">Rp {{ number_format($totalDenda, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div style="margin-top: 30px; text-align: right; font-size: 10px;">
            <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
        </div>
    </div>

</x-app-layout>