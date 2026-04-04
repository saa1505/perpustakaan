<nav x-data="{ open: false }" 
class="sticky top-0 z-50 backdrop-blur-xl bg-white/60 border-b border-white/20">

    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        
        <div class="flex justify-end items-center h-16">

            {{-- RIGHT --}}
            <div class="flex items-center">

                <x-dropdown align="right" width="56">

                    {{-- 🔥 TRIGGER --}}
                    <x-slot name="trigger">
                        <button
                            class="group flex items-center gap-3 px-4 py-2 rounded-2xl 
                            bg-white/50 hover:bg-white/80 backdrop-blur-xl
                            border border-white/30 
                            shadow-[0_8px_30px_rgba(0,0,0,0.08)]
                            hover:shadow-[0_10px_40px_rgba(0,0,0,0.15)]
                            transition-all duration-300">

                            {{-- AVATAR --}}
                            <div class="relative">
                                <div class="w-9 h-9 rounded-full 
                                    bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 
                                    flex items-center justify-center text-white text-sm font-bold
                                    shadow-md">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>

                                {{-- ONLINE DOT --}}
                                <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-400 border-2 border-white rounded-full"></span>
                            </div>

                            {{-- NAME --}}
                            <div class="text-sm font-semibold text-gray-700 group-hover:text-gray-900 transition">
                                {{ Auth::user()->name }}
                            </div>

                            {{-- ICON --}}
                            <svg class="h-4 w-4 text-gray-400 group-hover:text-gray-600 transition"
                                viewBox="0 0 20 20">
                                <path fill="currentColor"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z"/>
                            </svg>
                        </button>
                    </x-slot>

                    {{-- 🔥 DROPDOWN --}}
                    <x-slot name="content">
                        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">

                            {{-- HEADER --}}
                            <div class="px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50">
                                <div class="text-sm font-semibold text-gray-800">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ Auth::user()->email }}
                                </div>
                            </div>

                            {{-- MENU --}}
                            <div class="py-2">

                                <a href="{{ route('profile.edit') }}"
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 transition">
                                    ⚙️ Profile
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition">
                                        🚪 Logout
                                    </button>
                                </form>

                            </div>

                        </div>
                    </x-slot>

                </x-dropdown>

            </div>

        </div>

    </div>
</nav>