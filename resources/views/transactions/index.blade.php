<x-app-layout>

    <div class="p-6">

        <h2 class="text-xl font-bold mb-4">📚 Transaksi Buku</h2>

        {{-- NOTIF --}}
        @if (session('success'))
            <div class="bg-green-200 p-3 mb-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- BUTTON --}}
        <button data-bs-toggle="modal" data-bs-target="#modalTambah"
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mb-4 shadow">
            + Pinjam Buku
        </button>

        {{-- TABEL --}}
        <div class="overflow-x-auto">
            <table class="w-full bg-white shadow rounded-lg overflow-hidden">

                {{-- HEADER --}}
                <thead class="bg-gray-800 text-white">
                    <tr class="text-center">
                        <th class="p-3">Siswa</th>
                        <th class="p-3">Buku</th>
                        <th class="p-3">Periode</th>
                        <th class="p-3">Denda</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>
                    @forelse($transactions as $trx)
                        <tr class="text-center border-b hover:bg-gray-100 transition">

                            {{-- SISWA --}}
                            <td class="p-2">{{ $trx->user->name }}</td>

                            {{-- BUKU --}}
                            <td class="p-2">{{ $trx->book->judul }}</td>

                            {{-- TANGGAL --}}
                            <td>
                                {{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d M Y') }}
                                -
                                @if ($trx->tanggal_kembali)
                                    {{ \Carbon\Carbon::parse($trx->tanggal_kembali)->format('d M Y') }}
                                @else
                                    <span class="text-gray-400 italic">Belum kembali</span>
                                @endif
                            </td>

                            {{-- DENDA --}}
                            <td class="p-2">
                                <span class="{{ $trx->denda > 0 ? 'text-red-500 font-bold' : '' }}">
                                    Rp {{ number_format($trx->denda) }}
                                </span>
                            </td>

                            {{-- STATUS --}}
                            <td class="p-2">
                                @if ($trx->status == 'pinjam')
                                    <span class="bg-yellow-400 px-3 py-1 rounded-full text-white text-sm shadow">
                                        Dipinjam
                                    </span>
                                @else
                                    <span class="bg-green-500 px-3 py-1 rounded-full text-white text-sm shadow">
                                        Dikembalikan
                                    </span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="p-2">
                                @if ($trx->status == 'pinjam')
                                    <form action="{{ route('transactions.kembali', $trx->id) }}" method="POST"
                                        class="flex items-center justify-center gap-2">
                                        @csrf

                                        <select name="kondisi"
                                            class="border border-gray-300 rounded px-2 py-1 text-sm focus:ring focus:ring-blue-200">
                                            <option value="baik">Baik</option>
                                            <option value="rusak">Rusak</option>
                                            <option value="hilang">Hilang</option>
                                        </select>

                                        <button
                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm shadow">
                                            ✔
                                        </button>
                                    </form>
                                @endif

                                {{-- TOMBOL HAPUS --}}
                                <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin mau hapus data ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="border border-gray-300 text-red-500 p-1.5 rounded-md 
                                        hover:bg-red-500 hover:text-white hover:border-red-500 
                                        transition duration-200">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-1 14H6L5 7m5 4v6m4-6v6M9 7h6m-7-2h8a1 1 0 011 1v1H4V6a1 1 0 011-1z" />
                                        </svg>

                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-4">
                                Belum ada transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

    {{-- ================= MODAL PINJAM ================= --}}
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                {{-- HEADER --}}
                <div class="modal-header">
                    <h5 class="modal-title">Pinjam Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                {{-- BODY --}}
                <div class="modal-body">
                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf

                        {{-- SISWA --}}
                        <div class="mb-3">
                            <label class="form-label">Pilih Siswa</label>
                            <select name="user_id" class="form-select">
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- BUKU --}}
                        <div class="mb-3">
                            <label class="form-label">Pilih Buku</label>
                            <select name="book_id" class="form-select">
                                @foreach ($books as $b)
                                    <option value="{{ $b->id }}">{{ $b->judul }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            Pinjam
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- BOOTSTRAP --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</x-app-layout>
