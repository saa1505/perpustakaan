<x-app-layout>

    <div class="py-12 min-h-screen bg-gradient-to-br from-slate-100 via-blue-100 to-indigo-200">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 🔥 HEADER --}}
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-gray-800">
                    Profile Settings ⚙️
                </h2>
                <p class="text-gray-500 text-sm">
                    Kelola akun dan keamanan kamu
                </p>
            </div>

            {{-- 🔥 PROFILE INFO --}}
            <div class="p-6 sm:p-8 rounded-3xl bg-white/60 backdrop-blur-xl border border-white/30 shadow-xl">

                <h3 class="text-lg font-semibold text-gray-700 mb-4">
                    👤 Informasi Profil
                </h3>

                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>

            </div>

            {{-- 🔥 PASSWORD --}}
            <div class="p-6 sm:p-8 rounded-3xl bg-white/60 backdrop-blur-xl border border-white/30 shadow-xl">

                <h3 class="text-lg font-semibold text-gray-700 mb-4">
                    🔐 Ubah Password
                </h3>

                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>

            </div>

            {{-- 🔥 DELETE --}}
            <div class="p-6 sm:p-8 rounded-3xl bg-white/60 backdrop-blur-xl border border-red-200 shadow-xl">

                <h3 class="text-lg font-semibold text-red-600 mb-4">
                    ⚠️ Danger Zone
                </h3>

                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>

            </div>

        </div>

    </div>

</x-app-layout>