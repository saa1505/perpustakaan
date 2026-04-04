<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <style>
        /* Fix bagian "Tampilkan data" */
        .dataTables_length label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .dataTables_length select {
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            background-color: #fff;
            min-width: 70px;
        }

        /* Fix search */
        .dataTables_filter {
            margin-bottom: 10px;
        }

        .dataTables_filter input {
            margin-left: 8px;
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex">

        <!-- Sidebar -->
        <!-- Sidebar -->
        <div
            class="w-64 min-h-screen p-6 
    bg-white/70 backdrop-blur-2xl 
    border-r border-white/30 
    shadow-xl relative">

            <!-- LOGO -->
            <div class="flex justify-center items-center mb-10">
                <h5 class="text-2xl font-semibold text-gray-800 tracking-wide">
                    ADMIN PANEL
                </h5>
            </div>

            <!-- MENU -->
            <ul class="space-y-2">

                <!-- Dashboard -->
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 relative
                {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">

                        <!-- Active bar -->
                        @if (request()->routeIs('dashboard'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-blue-500 rounded-r-full"></div>
                        @endif

                        <span class="text-lg">📊</span>
                        <span class="font-medium">Dashboard</span>
                    </a>
                </li>

                <!-- Buku -->
                <li>
                    <a href="{{ route('books.index') }}"
                        class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 relative
                {{ request()->routeIs('books.*') ? 'bg-purple-50 text-purple-600 shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">

                        @if (request()->routeIs('books.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-purple-500 rounded-r-full"></div>
                        @endif

                        <span class="text-lg">📚</span>
                        <span class="font-medium">Buku</span>
                    </a>
                </li>

                <!-- Transaksi -->
                <li>
                    <a href="{{ route('transactions.index') }}"
                        class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 relative
                {{ request()->routeIs('transactions.*')
                    ? 'bg-pink-50 text-pink-600 shadow-sm'
                    : 'text-gray-600 hover:bg-gray-100' }}">

                        @if (request()->routeIs('transactions.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-pink-500 rounded-r-full"></div>
                        @endif

                        <span class="text-lg">💳</span>
                        <span class="font-medium">Transaksi</span>
                    </a>
                </li>

                <!-- Anggota -->
                <li>
                    <a href="{{ route('users.index') }}"
                        class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 relative
                {{ request()->routeIs('users.*') ? 'bg-green-50 text-green-600 shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">

                        @if (request()->routeIs('users.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-green-500 rounded-r-full"></div>
                        @endif

                        <span class="text-lg">👥</span>
                        <span class="font-medium">Anggota</span>
                    </a>
                </li>

            </ul>

            <!-- PROFILE -->
            <div class="absolute bottom-6 left-6 right-6">

                <div
                    class="flex items-center gap-3 p-3 rounded-2xl 
            bg-gradient-to-r from-blue-50 to-purple-50 
            border border-white shadow-sm">

                    <div
                        class="w-10 h-10 rounded-full 
                bg-gradient-to-r from-blue-500 to-purple-500 
                flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>

                    <div>
                        <div class="text-sm font-semibold text-gray-800">
                            {{ Auth::user()->name }}
                        </div>
                        <div class="text-xs text-gray-500">
                            Online
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Content -->
        <div class="flex-1">

            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>

        </div>

    </div>
</body>

</html>
