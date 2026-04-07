<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header">
            <h4>Edit Buku</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('books.update', $book->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Judul</label>
                    <input type="text" name="judul" value="{{ $book->judul }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Penulis</label>
                    <input type="text" name="penulis" value="{{ $book->penulis }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Penerbit</label>
                    <input type="text" name="penerbit" value="{{ $book->penerbit }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Tahun</label>
                    <input type="number" name="tahun" value="{{ $book->tahun }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="kategori" class="form-control">
                        <option value="dongeng" {{ $book->kategori == 'dongeng' ? 'selected' : '' }}>Dongeng</option>
                        <option value="fiksi" {{ $book->kategori == 'fiksi' ? 'selected' : '' }}>Fiksi</option>
                        <option value="non-fiksi" {{ $book->kategori == 'non-fiksi' ? 'selected' : '' }}>Non-Fiksi
                        </option>
                        <option value="sejarah" {{ $book->kategori == 'sejarah' ? 'selected' : '' }}>Sejarah</option>
                        <option value="kenangan" {{ $book->kategori == 'kenangan' ? 'selected' : '' }}>Kenangan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Stok</label>
                    <input type="number" name="stok" value="{{ $book->stok }}" class="form-control">
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('books.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>
