<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* FADE MASUK */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.8s ease;
        }

        /* SHAKE ERROR */
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .shake {
            animation: shake 0.3s;
        }

        /* TEXT MASUK */
        @keyframes slideLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-slideLeft {
            animation: slideLeft 1s ease forwards;
        }

        .delay-1 {
            animation-delay: 0.3s;
            opacity: 0;
        }

        .delay-2 {
            animation-delay: 0.6s;
            opacity: 0;
        }

        /* FORM MASUK */
        @keyframes slideRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-slideRight {
            animation: slideRight 1s ease;
        }

        /* BACKGROUND ZOOM */
        @keyframes zoomBg {
            from {
                transform: scale(1);
            }

            to {
                transform: scale(1.1);
            }
        }

        .bg-zoom {
            animation: zoomBg 20s ease-in-out infinite alternate;
        }
    </style>

</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-900 via-gray-900 to-blue-900">

    <div class="w-full max-w-6xl flex rounded-3xl overflow-hidden shadow-2xl animate-fadeIn">

        <!-- LEFT -->
        <div class="hidden md:flex w-1/2 relative overflow-hidden">

            <!-- BACKGROUND IMAGE -->
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da"
                    class="w-full h-full object-cover bg-zoom">
            </div>

            <!-- OVERLAY -->
            <div class="absolute inset-0 bg-black/60"></div>

            <!-- CONTENT -->
            <div class="relative z-10 p-12 flex flex-col justify-center text-white">

                <h1 class="text-4xl font-bold mb-4 animate-slideLeft delay-1">
                    Perpustakaan App 📚
                </h1>

                <p class="text-lg opacity-90 max-w-md animate-slideLeft delay-2">
                    Kelola data anggota, buku, dan transaksi dengan cepat dan modern.
                </p>

            </div>

        </div>

        <!-- RIGHT -->
        <div class="w-full md:w-1/2 bg-white/10 backdrop-blur-xl p-10 flex items-center animate-slideRight">

            <div class="w-full max-w-md mx-auto">

                <h2 class="text-2xl font-semibold text-white mb-6 text-center">
                    Login Account
                </h2>

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <!-- EMAIL -->
                    <div class="mb-4 relative">
                        <label class="text-sm text-gray-300">Email</label>
                        <input type="email" name="email"
                            class="w-full mt-1 px-10 py-2 rounded-xl bg-white/20 text-white border border-white/30 outline-none focus:ring-2 focus:ring-indigo-400 transition duration-300 hover:scale-[1.02]"
                            placeholder="Masukkan email" required>

                        <span class="absolute left-3 top-9 text-gray-300">📧</span>
                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-4 relative">
                        <label class="text-sm text-gray-300">Password</label>
                        <input id="password" type="password" name="password"
                            class="w-full mt-1 px-10 py-2 rounded-xl bg-white/20 text-white border border-white/30 outline-none focus:ring-2 focus:ring-indigo-400 transition duration-300 hover:scale-[1.02]"
                            placeholder="Masukkan password" required>

                        <span class="absolute left-3 top-9 text-gray-300">🔒</span>
                    </div>

                    <!-- REMEMBER -->
                    <div class="flex justify-between items-center mb-4 text-sm text-gray-300">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="remember">
                            Remember me
                        </label>

                        <a href="#" class="hover:underline text-indigo-300">Forgot?</a>
                    </div>

                    <!-- BUTTON -->
                    <button id="loginBtn"
                        class="w-full py-2.5 rounded-xl text-white bg-gradient-to-r from-indigo-500 to-blue-500 
                        hover:scale-105 transition duration-300 shadow-lg hover:shadow-indigo-500/50">
                        Login
                    </button>

                    <div class="mt-6 text-center text-sm text-gray-300">
                        <span class="opacity-80">Belum punya akun?</span>

                        <a href="{{ route('register') }}"
                            class="ml-1 px-3 py-1 rounded-lg bg-white/10 hover:bg-white/20 text-indigo-300 
        transition duration-300 backdrop-blur">
                            Daftar sekarang 
                        </a>
                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>
        function togglePassword() {
            const pass = document.getElementById('password');
            pass.type = pass.type === 'password' ? 'text' : 'password';
        }

        // Loading button
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.innerHTML = "Loading...";
            btn.disabled = true;
        });

        // Error animation
        @if ($errors->any())
            document.getElementById('loginForm').classList.add('shake');
        @endif
    </script>

</body>

</html>
