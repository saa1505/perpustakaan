<x-app-layout>

    <div class="p-6 bg-gradient-to-br from-blue-50 via-white to-indigo-50 min-h-screen">

        {{-- TITLE --}}
        <h3 class="text-2xl font-semibold text-gray-800 mb-6 tracking-tight">
            📚 Halaman Buku
        </h3>

        {{-- NOTIF --}}
        @if (session('success'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-green-100 text-green-700 shadow">
                {{ session('success') }}
            </div>
        @endif

        {{-- BUTTON TAMBAH --}}
        <button
            class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-5 py-2.5 rounded-xl shadow-md hover:scale-105 hover:shadow-lg transition mb-6"
            data-bs-toggle="modal" data-bs-target="#modalTambah">
            + Tambah Buku
        </button>

        {{-- TABLE WRAPPER --}}
        <div class="bg-white/70 backdrop-blur-xl p-6 rounded-3xl shadow-xl border border-white/40">

            <div class="overflow-x-auto">
                <table id="myTable" class="w-full text-sm rounded-2xl overflow-hidden">

                    {{-- HEADER --}}
                    <thead class="bg-gradient-to-r from-gray-800 to-gray-700 text-white">
                        <tr class="text-center">
                            <th class="py-3">Cover Buku</th>
                            <th class="py-3">Judul</th>
                            <th class="py-3">Penulis</th>
                            <th class="py-3">Penerbit</th>
                            <th class="py-3">Tahun</th>
                            <th class="py-3">Kategori</th>
                            <th class="py-3">Stok</th>
                            <th class="py-3">Aksi</th>
                        </tr>
                    </thead>

                    {{-- BODY --}}
                    <tbody class="text-gray-700">
                        @forelse ($books as $book)
                            <tr class="text-center hover:bg-blue-50/40 transition duration-200">
                                <td>
                                    @if ($book->image)
                                        <img src="{{ asset('storage/' . $book->image) }}"
                                            class="w-12 h-12 object-cover rounded-lg mx-auto border shadow">
                                    @else
                                        <img src="https://via.placeholder.com/50" class="w-12 h-12 rounded-lg mx-auto">
                                    @endif
                                </td>
                                <td class="py-2 font-medium">{{ $book->judul }}</td>
                                <td>{{ $book->penulis }}</td>
                                <td>{{ $book->penerbit }}</td>
                                <td>{{ $book->tahun }}</td>
                                <td>{{ $book->kategori }}</td>
                                <td class="font-semibold text-blue-600">{{ $book->stok }}</td>

                                <td class="text-center">

                                    <div class="flex justify-center items-center gap-2">

                                        {{-- EDIT --}}
                                        <button
                                            class="w-10 h-10 flex items-center justify-center 
    border border-yellow-500 text-yellow-500 
    rounded-md bg-transparent 
    hover:bg-yellow-50 transition btn-edit"
                                            data-id="{{ $book->id }}" data-judul="{{ $book->judul }}"
                                            data-penulis="{{ $book->penulis }}" data-penerbit="{{ $book->penerbit }}"
                                            data-tahun="{{ $book->tahun }}" data-kategori="{{ $book->kategori }}"
                                            data-stok="{{ $book->stok }}" data-bs-toggle="modal"
                                            data-bs-target="#modalEdit"> <!-- 🔥 INI WAJIB -->

                                            <!-- ICON PENSIL (FIX) -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213l-4 1 1-4L16.862 3.487z" />

                                            </svg>

                                        </button>

                                        {{-- DELETE --}}
                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button onclick="return confirm('Yakin mau hapus data ?')"
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
                                <td colspan="7" class="text-center py-4 text-gray-500">
                                    Belum ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        {{-- ================= MODAL TAMBAH ================= --}}
        <div class="modal fade" id="modalTambah" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content rounded-3xl shadow-2xl border-0">

                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title font-semibold">Tambah Buku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body pt-2">
                        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label>Gambar Buku</label>
                                <input type="file" name="image" class="form-control">
                            </div>

                            {{-- JUDUL (PALING ATAS) --}}
                            <div class="mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" name="judul" class="form-control" placeholder="Masukkan judul"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="kategori"
                                    class="form-control rounded-xl border-gray-200 focus:ring-2 focus:ring-blue-400"
                                    required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="dongeng">Dongeng</option>
                                    <option value="fiksi">Fiksi</option>
                                    <option value="non-fiksi">Non-Fiksi</option>
                                    <option value="sejarah">Sejarah</option>
                                    <option value="kenangan">Kenangan</option>
                                </select>
                            </div>

                            @foreach (['penulis', 'penerbit', 'tahun', 'stok'] as $field)
                                <div class="mb-3">
                                    <label class="form-label capitalize">{{ $field }}</label>
                                    <input type="{{ $field == 'tahun' || $field == 'stok' ? 'number' : 'text' }}"
                                        name="{{ $field }}"
                                        class="form-control rounded-xl border-gray-200 focus:ring-2 focus:ring-blue-400"
                                        placeholder="Masukkan {{ $field }}" required>
                                </div>
                            @endforeach

                            <button type="submit"
                                class="w-full bg-green-500 text-white py-2 rounded-xl hover:bg-green-600 transition">
                                Simpan
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        {{-- ================= MODAL EDIT ================= --}}
        <div class="modal fade" id="modalEdit" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content rounded-3xl shadow-2xl border-0">

                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title font-semibold">Edit Buku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body pt-2">
                        <form id="formEdit" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label>Gambar Buku</label>
                                <input type="file" name="image" class="form-control">
                            </div>

                            {{-- JUDUL --}}
                            <div class="mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" id="edit_judul" name="judul"
                                    class="form-control rounded-xl border-gray-200">
                            </div>

                            {{-- KATEGORI (HANYA 1x DI SINI) --}}
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select id="edit_kategori" name="kategori"
                                    class="form-control rounded-xl border-gray-200">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="dongeng">Dongeng</option>
                                    <option value="fiksi">Fiksi</option>
                                    <option value="non-fiksi">Non-Fiksi</option>
                                    <option value="sejarah">Sejarah</option>
                                    <option value="kenangan">Kenangan</option>
                                </select>
                            </div>

                            {{-- FIELD LAIN --}}
                            @foreach (['penulis', 'penerbit', 'tahun', 'stok'] as $field)
                                <div class="mb-3">
                                    <label class="form-label capitalize">{{ $field }}</label>
                                    <input type="{{ $field == 'tahun' || $field == 'stok' ? 'number' : 'text' }}"
                                        id="edit_{{ $field }}" name="{{ $field }}"
                                        class="form-control rounded-xl border-gray-200">
                                </div>
                            @endforeach

                            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-xl">
                                Update
                            </button> 
                        </form>
                    </div>

                </div>
            </div>
        </div>

        {{-- ================= SCRIPT ================= --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            const modalEdit = document.getElementById('modalEdit');

            modalEdit.addEventListener('show.bs.modal', function(event) {

                const button = event.relatedTarget;

                ['judul', 'penulis', 'penerbit', 'tahun', 'kategori', 'stok'].forEach(field => {
                    document.getElementById('edit_' + field).value =
                        button.getAttribute('data-' + field);
                });

                document.getElementById('formEdit').action =
                    `/books/${button.getAttribute('data-id')}`;
            });
        </script>

        <!-- DataTables -->
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#myTable').DataTable({
                    pageLength: 5
                });
            });
        </script>

</x-app-layout>
