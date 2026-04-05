<x-app-layout>

    <div class="p-6 bg-gradient-to-br from-blue-50 via-white to-indigo-50 min-h-screen">

        {{-- TITLE --}}
        <h2 class="text-2xl font-semibold mb-4 flex items-center gap-2">
            📚 <span>Transaksi Buku</span>
        </h2>

        {{-- NOTIF --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl mb-4 shadow">
                {{ session('success') }}
            </div>
        @endif

        {{-- BUTTON --}}
        <button data-bs-toggle="modal" data-bs-target="#modalTambah"
            class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-5 py-2.5 rounded-xl shadow-md hover:scale-105 hover:shadow-lg transition mb-6">
            + Pinjam Buku
        </button>

        {{-- TABLE --}}
        <div class="bg-white/70 backdrop-blur-xl p-6 rounded-3xl shadow-xl border border-white/40">

            <div class="overflow-x-auto">
                <table id="myTable" class="w-full text-sm rounded-2xl overflow-hidden">

                    {{-- HEADER --}}
                    <thead class="bg-gradient-to-r from-gray-800 to-gray-700 text-white">
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
                            <tr
                                class="bg-white rounded-xl shadow-sm hover:shadow-lg transition duration-300 text-center">

                                {{-- SISWA --}}
                                <td class="p-4 font-medium">
                                    {{ $trx->user->name }}
                                </td>

                                {{-- BUKU --}}
                                <td class="p-4">
                                    {{ $trx->book->judul }}
                                </td>

                                {{-- PERIODE --}}
                                <td class="p-4 text-sm">
                                    {{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d M Y') }}
                                    -
                                    @if ($trx->tanggal_kembali)
                                        {{ \Carbon\Carbon::parse($trx->tanggal_kembali)->format('d M Y') }}
                                    @else
                                        <span class="text-gray-400 italic">Belum kembali</span>
                                    @endif
                                </td>

                                {{-- DENDA --}}
                                <td class="p-4">
                                    <div class="flex flex-col items-center gap-1">

                                        <span
                                            class="text-sm font-semibold 
                                            {{ $trx->denda > 0 ? 'text-red-500' : 'text-gray-700' }}">
                                            Rp {{ number_format($trx->denda) }}
                                        </span>

                                        @if ($trx->kondisi)
                                            <span
                                                class="px-3 py-1 text-xs rounded-full font-medium
                                                {{ $trx->kondisi == 'baik' ? 'bg-green-100 text-green-600' : '' }}
                                                {{ $trx->kondisi == 'rusak' ? 'bg-yellow-100 text-yellow-600' : '' }}
                                                {{ $trx->kondisi == 'hilang' ? 'bg-red-100 text-red-600' : '' }}">
                                                {{ ucfirst($trx->kondisi) }}
                                            </span>
                                        @endif

                                    </div>
                                </td>

                                {{-- STATUS --}}
                                <td class="p-4">
                                    @if ($trx->status == 'pinjam')
                                        <span
                                            class="px-4 py-1 rounded-full text-xs font-semibold 
                                            bg-yellow-400 text-white shadow">
                                            Dipinjam
                                        </span>
                                    @else
                                        <span
                                            class="px-4 py-1 rounded-full text-xs font-semibold 
                                            bg-green-500 text-white shadow">
                                            Dikembalikan
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="p-4 min-w-[160px]">

                                    <div class="flex flex-col items-center gap-2">

                                        {{-- FORM KEMBALI --}}
                                        @if ($trx->status == 'pinjam')
                                            <form action="{{ route('transactions.kembali', $trx->id) }}" method="POST"
                                                class="flex items-center gap-2 bg-gray-100 px-2 py-1 rounded-lg">
                                                @csrf

                                                <select name="kondisi"
                                                    class="text-xs border-none bg-transparent focus:ring-0">
                                                    <option value="baik">Baik</option>
                                                    <option value="rusak">Rusak</option>
                                                    <option value="hilang">Hilang</option>
                                                </select>

                                                <button
                                                    class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">
                                                    ✔
                                                </button>
                                            </form>
                                        @endif

                                        {{-- DELETE --}}
                                        <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button onclick="return confirm('Yakin hapus?')"
                                                class="w-10 h-10 flex items-center justify-center 
                border border-red-500 text-red-500 
                rounded-md bg-transparent 
                hover:bg-red-50 transition">

                                                <!-- ICON DELETE -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v2H9V4a1 1 0 011-1z" />

                                                </svg>

                                            </button>
                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-6 text-gray-400">
                                    Belum ada transaksi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>
        </div>

    </div>

    {{-- ================= MODAL ================= --}}
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-2xl border-0 shadow-lg">

                {{-- HEADER --}}
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-semibold">Pinjam Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                {{-- BODY --}}
                <div class="modal-body">
                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Pilih Siswa</label>
                            <select name="user_id" class="form-select rounded-xl">
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pilih Buku</label>
                            <select name="book_id" class="form-select rounded-xl">
                                @foreach ($books as $b)
                                    <option value="{{ $b->id }}">{{ $b->judul }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" value="{{ date('Y-m-d') }}"
                                class="form-control rounded-xl" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Kembali</label>
                            <input type="date" name="tanggal_kembali" class="form-control rounded-xl" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100 rounded-xl shadow">
                            Pinjam
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50],
                language: {
                    search: " Search:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        next: "Next",
                        previous: "Prev"
                    },
                    zeroRecords: "Data tidak ditemukan"
                }
            });
        });
    </script>

</x-app-layout>
