<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 p-4 rounded-lg">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">

                    <!-- Total Stok -->
                    <div class="bg-green-500 text-white p-5 rounded-lg shadow">
                        <h4 class="text-sm">Total Stok</h4>
                        <p class="text-2xl font-bold">{{ $totalStok }}</p>
                    </div>

                    <!-- Total Siswa -->
                    <div class="bg-blue-500 text-white p-5 rounded-lg shadow">
                        <h4 class="text-sm">Total Siswa</h4>
                        <p class="text-2xl font-bold">{{ $totalSiswa }}</p>
                    </div>

                    <!-- Total Dipinjam -->
                    <div class="bg-yellow-500 text-white p-5 rounded-lg shadow">
                        <h4 class="text-sm">Dipinjam</h4>
                        <p class="text-2xl font-bold">{{ $totalDipinjam }}</p>
                    </div>

                    <!-- Total Dikembalikan -->
                    <div class="bg-red-500 text-white p-5 rounded-lg shadow">
                        <h4 class="text-sm">Dikembalikan</h4>
                        <p class="text-2xl font-bold">{{ $totalKembali }}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
