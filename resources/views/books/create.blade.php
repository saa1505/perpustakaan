<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('books.store') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="mb-2">
                        <label>Judul</label>
                        <input type="text" name="judul" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Penulis</label>
                        <input type="text" name="penulis" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Penerbit</label>
                        <input type="text" name="penerbit" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Tahun</label>
                        <input type="number" name="tahun" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Kategori</label>
                        <select name="kategori" class="form-control">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="dongeng">Dongeng</option>
                            <option value="fiksi">Fiksi</option>
                            <option value="non-fiksi">Non-Fiksi</option>
                            <option value="sejarah">Sejarah</option>
                            <option value="kenangan">Kenangan</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>
