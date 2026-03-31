<x-app-layout>

    {{-- BOOTSTRAP CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container mt-4">

        <h3 class="mb-3">📚 Halaman Buku</h3>

        {{-- NOTIF --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- BUTTON TAMBAH --}}
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
            + Tambah Buku
        </button>

        {{-- TABEL --}}
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($books as $book)
                    <tr>
                        <td>{{ $book->judul }}</td>
                        <td>{{ $book->penulis }}</td>
                        <td>{{ $book->penerbit }}</td>
                        <td>{{ $book->tahun }}</td>
                        <td>{{ $book->kategori }}</td>
                        <td>{{ $book->stok }}</td>
                        <td>

                            {{-- EDIT --}}
                            <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $book->id }}"
                                data-judul="{{ $book->judul }}" data-penulis="{{ $book->penulis }}"
                                data-penerbit="{{ $book->penerbit }}" data-tahun="{{ $book->tahun }}"
                                data-kategori="{{ $book->kategori }}" data-stok="{{ $book->stok }}" 
                                data-bs-toggle="modal" data-bs-target="#modalEdit">
                                Edit
                            </button>

                            {{-- DELETE --}}
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">
                                    Hapus
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    {{-- ================= MODAL TAMBAH ================= --}}
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('books.store') }}" method="POST">
                        @csrf

                        <div class="mb-2">
                            <label class="form-label">Judul</label>
                            <input type="text" name="judul" class="form-control" placeholder="Masukkan judul"
                                required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Penulis</label>
                            <input type="text" name="penulis" class="form-control" placeholder="Masukkan penulis"
                                required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Penerbit</label>
                            <input type="text" name="penerbit" class="form-control" placeholder="Masukkan penerbit"
                                required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Tahun Terbit</label>
                            <input type="number" name="tahun" class="form-control" placeholder="Masukkan tahun"
                                required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="kategori" class="form-control" placeholder="Masukkan kategori"
                                required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control" placeholder="Masukkan stok"
                                required>
                        </div>

                        <button type="submit" class="btn btn-success mt-2">Simpan</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- ================= MODAL EDIT ================= --}}
    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="formEdit" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-2">
                            <label class="form-label">Judul</label>
                            <input type="text" id="edit_judul" name="judul" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Penulis</label>
                            <input type="text" id="edit_penulis" name="penulis" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Penerbit</label>
                            <input type="text" id="edit_penerbit" name="penerbit" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Tahun Terbit</label>
                            <input type="number" id="edit_tahun" name="tahun" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Kategori</label>
                            <input type="text" id="edit_kategori" name="penerbit" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Stok Baru</label>
                            <input type="number" id="edit_stok" name="stok" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success mt-2">Update</button>
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

            document.getElementById('edit_judul').value = button.getAttribute('data-judul');
            document.getElementById('edit_penulis').value = button.getAttribute('data-penulis');
            document.getElementById('edit_penerbit').value = button.getAttribute('data-penerbit');
            document.getElementById('edit_tahun').value = button.getAttribute('data-tahun');
            document.getElementById('edit_kategori').value = button.getAttribute('data-kategori');
            document.getElementById('edit_stok').value = button.getAttribute('data-stok');

            document.getElementById('formEdit').action = `/books/${button.getAttribute('data-id')}`;
        });
    </script>

</x-app-layout>
