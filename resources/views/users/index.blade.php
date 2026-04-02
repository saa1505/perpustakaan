<x-app-layout>

    <div class="p-6">

        <h2 class="text-xl font-bold mb-6"> Kelola Anggota</h2>

        {{-- NOTIF --}}
        @if (session('success'))
            <div class="bg-green-200 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- BUTTON --}}
        <div class="mb-4">
            <button data-bs-toggle="modal" data-bs-target="#modalTambah"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                + Tambah Anggota
            </button>
        </div>

        {{-- TABEL --}}
        <div class="overflow-x-auto">
            <table id="myTable" class="w-full bg-white shadow rounded-lg">

                <thead class="bg-gray-800 text-white">
                    <tr class="text-center">
                        <th class="p-3">Nama</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $u)
                        <tr class="text-center border-b hover:bg-gray-100">
                            <td class="p-2">{{ $u->name }}</td>
                            <td class="p-2">{{ $u->email }}</td>

                            <td class="p-2">
                                <div class="flex justify-center gap-2">

                                    {{-- EDIT --}}
                                    <button class="bg-yellow-400 px-2 py-1 rounded text-sm"
                                        data-id="{{ $u->id }}" data-name="{{ $u->name }}"
                                        data-email="{{ $u->email }}" data-bs-toggle="modal"
                                        data-bs-target="#modalEdit">
                                        Edit
                                    </button>

                                    {{-- DELETE --}}
                                    <form action="{{ route('users.destroy', $u->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button onclick="return confirm('Yakin hapus?')"
                                            class="bg-red-500 text-white px-2 py-1 rounded text-sm">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>

    {{-- ================= MODAL TAMBAH ================= --}}
    <div class="modal fade" id="modalTambah">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5>Tambah Anggota</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="mb-2">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <button class="btn btn-success w-100 mt-2">Simpan</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- ================= MODAL EDIT ================= --}}
    <div class="modal fade" id="modalEdit">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5>Edit Anggota</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="formEdit" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-2">
                            <label>Nama</label>
                            <input type="text" id="edit_name" name="name" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label>Email</label>
                            <input type="email" id="edit_email" name="email" class="form-control">
                        </div>

                        <button class="btn btn-success w-100 mt-2">Update</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const modal = document.getElementById('modalEdit');

            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                document.getElementById('edit_name').value = button.getAttribute('data-name');
                document.getElementById('edit_email').value = button.getAttribute('data-email');

                document.getElementById('formEdit').action = `/users/${button.getAttribute('data-id')}`;
            });

        });
    </script>

    <!-- DataTables -->
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
