@extends('layouts.user')

@section('content')
    <div class="container mt-5 pt-5">

        <h2 class="mb-4">📚 Transaksi Saya</h2>

        {{-- NOTIF --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table id="tableTransaksi" class="table table-bordered shadow">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Buku</th>
                    <th>Status</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($transaksi as $t)
                    @php
                        $denda = 0;

                        if ($t->is_confirmed) {
                            if ($t->tanggal_kembali) {
                                $batas = \Carbon\Carbon::parse($t->tanggal_pinjam)->addDays(7);
                                $kembali = \Carbon\Carbon::parse($t->tanggal_kembali);

                                if ($kembali->gt($batas)) {
                                    $telat = $batas->diffInDays($kembali);
                                    $denda = $telat * 2000;
                                }
                            }
                        }
                    @endphp

                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $t->book->judul }}</td>

                        <td>
                            <span class="badge bg-warning text-dark">
                                {{ $t->status }}
                            </span>
                        </td>

                        <td>{{ $t->tanggal_pinjam }}</td>

                        {{-- ✅ FIX DI SINI --}}
                        <td>
                            {{ $t->tanggal_kembali ?? '-' }}
                        </td>

                        <td>
                            Rp {{ number_format($denda, 0, ',', '.') }}
                        </td>

                        <td class="d-flex gap-2">

                            {{-- EDIT --}}
                            @if (!$t->is_confirmed)
                                <button class="btn btn-sm btn-light border rounded-circle shadow-sm"
                                    onclick="openModal({{ $t->id }}, '{{ $t->tanggal_kembali }}', {{ $t->book->id }})"
                                    title="Edit">
                                    <i class="bi bi-pencil-fill text-warning"></i>
                                </button>
                            @else
                                <span class="text-muted">Terkunci</span>
                            @endif

                            {{-- HAPUS --}}
                            <form action="/transaksi/delete/{{ $t->id }}" method="POST"
                                onsubmit="return confirm('Yakin mau hapus transaksi ini?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-light border rounded-circle shadow-sm" title="Hapus">
                                    <i class="bi bi-trash-fill text-danger"></i>
                                </button>
                            </form>

                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>


        <!-- MODAL EDIT -->
        <div class="modal fade" id="editModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Tanggal Kembali</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form method="POST" id="formEdit">
                        @csrf

                        <div class="modal-body">

                            <label class="form-label">Tanggal Kembali</label>
                            <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control" required>

                            <label class="form-label mt-2">Nama Buku</label>
                            <select name="book_id" id="edit_buku" class="form-select rounded-3 shadow-sm" required>
                                @foreach ($books as $b)
                                    <option value="{{ $b->id }}">{{ $b->judul }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success w-100">
                                Simpan
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>

    <script>
        function openModal(id, tanggal, bookId) {

            document.getElementById('tanggal_kembali').value = tanggal ?? '';

            // set selected buku
            document.getElementById('edit_buku').value = bookId;

            document.getElementById('formEdit').action = `/transaksi/edit/${id}`;

            var myModal = new bootstrap.Modal(document.getElementById('editModal'));
            myModal.show();
        }
    </script>
@endsection
