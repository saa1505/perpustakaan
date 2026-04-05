<x-app-layout>

    <div class="p-6 bg-gradient-to-br from-blue-50 via-white to-indigo-50 min-h-screen">

        {{-- TITLE --}}
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">
            👥 Kelola Anggota
        </h2>

        {{-- NOTIF --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 mb-5 rounded-xl shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- BUTTON --}}

            <button data-bs-toggle="modal" data-bs-target="#modalTambah"
               class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-5 py-2.5 rounded-xl shadow-md hover:scale-105 hover:shadow-lg transition mb-6">
                + Tambah Anggota
            </button>


        {{-- CARD TABLE --}}
        <div class="bg-white/70 backdrop-blur-xl p-6 pt-3 pb-2 rounded-3xl shadow-xl border border-white/40">

            <div class="overflow-x-auto">
                <table id="myTable" class="w-full text-sm rounded-2xl overflow-hidden">

                    {{-- HEADER --}}
                    <thead class="bg-gradient-to-r from-gray-800 to-gray-700 text-white">
                        <tr class="text-center">
                        <th class="p-4">Nama</th>
                        <th class="p-4">Email</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>
                    @foreach ($users as $u)
                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="p-4 font-medium text-gray-700">
                                {{ $u->name }}
                            </td>

                            <td class="p-4 text-gray-500">
                                {{ $u->email }}
                            </td>

                            <td class="p-4">
                                <div class="flex justify-center gap-3">

                                    {{-- EDIT --}}
                                    <button
                                        class="w-10 h-10 flex items-center justify-center rounded-lg border border-yellow-400 text-yellow-500 hover:bg-yellow-50 transition"
                                        data-id="{{ $u->id }}"
                                        data-name="{{ $u->name }}"
                                        data-email="{{ $u->email }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEdit">

                                         <!-- ICON PENSIL (FIX) -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213l-4 1 1-4L16.862 3.487z" />

                                            </svg>
                                    </button>

                                    {{-- DELETE --}}
                                    <form action="{{ route('users.destroy', $u->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button onclick="return confirm('Yakin hapus?')"
                                            class="w-10 h-10 flex items-center justify-center rounded-lg border border-red-400 text-red-500 hover:bg-red-50 transition">

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
                    @endforeach
                </tbody>

            </table>

        </div>

    </div>

    {{-- ================= MODAL TAMBAH ================= --}}
    <div class="modal fade" id="modalTambah">
        <div class="modal-dialog">
            <div class="modal-content rounded-3 shadow">

                <div class="modal-header border-0">
                    <h5 class="fw-semibold">Tambah Anggota</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="text-sm">Nama</label>
                            <input type="text" name="name"
                                class="form-control rounded-lg shadow-sm">
                        </div>

                        <div class="mb-3">
                            <label class="text-sm">Email</label>
                            <input type="email" name="email"
                                class="form-control rounded-lg shadow-sm">
                        </div>

                        <button class="w-100 py-2 rounded-lg text-white bg-gradient-to-r from-green-500 to-emerald-600">
                            Simpan
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- ================= MODAL EDIT ================= --}}
    <div class="modal fade" id="modalEdit">
        <div class="modal-dialog">
            <div class="modal-content rounded-3 shadow">

                <div class="modal-header border-0">
                    <h5 class="fw-semibold">Edit Anggota</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="formEdit" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="text-sm">Nama</label>
                            <input type="text" id="edit_name" name="name"
                                class="form-control rounded-lg shadow-sm">
                        </div>

                        <div class="mb-3">
                            <label class="text-sm">Email</label>
                            <input type="email" id="edit_email" name="email"
                                class="form-control rounded-lg shadow-sm">
                        </div>

                        <button class="w-100 py-2 rounded-lg text-white bg-gradient-to-r from-blue-500 to-indigo-600">
                            Update
                        </button>
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

    {{-- DATATABLE --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 25],
                language: {
                    search: "Search:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
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