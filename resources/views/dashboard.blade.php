<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 🔍 SEARCH GLOBAL --}}
            <div class="mb-6 relative">
                <input type="text" id="searchInput" placeholder="Cari anggota, buku, transaksi, kondisi..."
                    class="w-full md:w-1/3 px-4 py-2 border rounded shadow">

                <div id="searchResult" class="absolute bg-white w-full md:w-1/3 mt-1 rounded shadow hidden z-50">
                </div>
            </div>

            {{-- CARD --}}
            <div class="bg-gray-100 p-4 rounded-lg mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">

                    <div class="bg-green-500 text-white p-5 rounded-lg shadow">
                        <h4 class="text-sm">Total Stok</h4>
                        <p class="text-2xl font-bold">{{ $totalStok }}</p>
                    </div>

                    <div class="bg-blue-500 text-white p-5 rounded-lg shadow">
                        <h4 class="text-sm">Total Siswa</h4>
                        <p class="text-2xl font-bold">{{ $totalSiswa }}</p>
                    </div>

                    <div class="bg-yellow-500 text-white p-5 rounded-lg shadow">
                        <h4 class="text-sm">Dipinjam</h4>
                        <p class="text-2xl font-bold">{{ $totalDipinjam }}</p>
                    </div>

                    <div class="bg-red-500 text-white p-5 rounded-lg shadow">
                        <h4 class="text-sm">Dikembalikan</h4>
                        <p class="text-2xl font-bold">{{ $totalKembali }}</p>
                    </div>

                </div>
            </div>

            {{-- 📊 TABEL GLOBAL --}}
            <div class="bg-white p-4 rounded-lg shadow">
                <table id="globalTable" class="w-full">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="p-2">Tipe</th>
                            <th class="p-2">Nama</th>
                            <th class="p-2">Detail</th>
                        </tr>
                    </thead>
                    <tbody>

                        {{-- USER --}}
                        @foreach ($users as $u)
                            <tr class="text-center border-b">
                                <td>Anggota</td>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                            </tr>
                        @endforeach

                        {{-- BUKU --}}
                        @foreach ($books as $b)
                            <tr class="text-center border-b">
                                <td>Buku</td>
                                <td>{{ $b->judul }}</td>
                                <td>{{ $b->penulis }}</td>
                            </tr>
                        @endforeach

                        {{-- TRANSAKSI --}}
                        @foreach ($transactions as $t)
                            <tr class="text-center border-b">
                                <td>Transaksi</td>
                                <td>{{ $t->user->name }}</td>
                                <td>
                                    {{ $t->book->judul }} |
                                    <span
                                        class="
                                    {{ $t->kondisi == 'baik' ? 'text-green-600' : '' }}
                                    {{ $t->kondisi == 'rusak' ? 'text-yellow-600' : '' }}
                                    {{ $t->kondisi == 'hilang' ? 'text-red-600' : '' }}">
                                        {{ $t->kondisi ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- DATATABLE --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            let table = $('#globalTable').DataTable({
                pageLength: 5
            });

            $('#globalSearch').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>

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

                    data.forEach(item => {
                        html += `
                    <div class="p-2 hover:bg-gray-100 cursor-pointer">
                        ${item.type} - ${item.name} (${item.detail})
                    </div>
                `;
                    });

                    let box = document.getElementById('searchResult');
                    box.innerHTML = html;
                    box.classList.remove('hidden');
                });
        });
    </script>

</x-app-layout>
