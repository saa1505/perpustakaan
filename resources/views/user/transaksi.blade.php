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

                        if ($t->tanggal_kembali) {
                            $batas = \Carbon\Carbon::parse($t->tanggal_pinjam)->addDays(7);
                            $kembali = \Carbon\Carbon::parse($t->tanggal_kembali);

                            if ($kembali->gt($batas)) {
                                $telat = $batas->diffInDays($kembali);
                                $denda = $telat * 2000;
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

                        {{-- ✅ FIX DI SINI --}}
                        <td>
                            <button class="btn btn-sm btn-warning"
                                onclick="openModal({{ $t->id }}, '{{ $t->tanggal_kembali }}')">
                                Edit
                            </button>
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
        function openModal(id, tanggal) {

            document.getElementById('tanggal_kembali').value = tanggal ?? '';

            document.getElementById('formEdit').action = `/transaksi/edit/${id}`;

            var myModal = new bootstrap.Modal(document.getElementById('editModal'));
            myModal.show();
        }
    </script>
@endsection
