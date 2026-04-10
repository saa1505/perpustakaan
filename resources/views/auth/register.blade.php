<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
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

    <div class="w-full max-w-4xl flex rounded-3xl overflow-hidden shadow-2xl animate-fadeIn">

        <!-- LEFT (SAMA KAYAK LOGIN) -->
        <div class="hidden md:flex w-1/2 relative overflow-hidden">

            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da"
                    class="w-full h-full object-cover bg-zoom">
            </div>

            <div class="absolute inset-0 bg-black/60"></div>

            <div class="relative z-10 p-12 flex flex-col justify-center text-white">

                <h1 class="text-4xl font-bold mb-4 animate-slideLeft delay-1">
                    Perpustakaan App 📚
                </h1>

                <p class="text-lg opacity-90 max-w-md animate-slideLeft delay-2">
                    Buat akun dan mulai kelola data perpustakaan dengan mudah.
                </p>

            </div>
        </div>

        <!-- RIGHT -->
        <div class="w-full md:w-1/2 bg-white/10 backdrop-blur-xl p-10 flex items-center animate-slideRight">

            <div class="w-full max-w-md mx-auto">

                <h2 class="text-2xl font-semibold text-white mb-6 text-center">
                    Register Account
                </h2>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- NAME -->
                    <div class="mb-4 relative">
                        <label class="text-sm text-gray-300">Name</label>
                        <input type="text" name="name"
                            class="w-full mt-1 px-4 py-2 rounded-xl bg-white/20 text-white border border-white/30 outline-none focus:ring-2 focus:ring-indigo-400"
                            required>
                    </div>

                    <!-- EMAIL -->
                    <div class="mb-4 relative">
                        <label class="text-sm text-gray-300">Email</label>
                        <input type="email" name="email"
                            class="w-full mt-1 px-4 py-2 rounded-xl bg-white/20 text-white border border-white/30 outline-none focus:ring-2 focus:ring-indigo-400"
                            required>
                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-4 relative">
                        <label class="text-sm text-gray-300">Password</label>
                        <input type="password" name="password"
                            class="w-full mt-1 px-4 py-2 rounded-xl bg-white/20 text-white border border-white/30 outline-none focus:ring-2 focus:ring-indigo-400"
                            required>
                    </div>

                    <!-- CONFIRM -->
                    <div class="mb-4 relative">
                        <label class="text-sm text-gray-300">Confirm Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full mt-1 px-4 py-2 rounded-xl bg-white/20 text-white border border-white/30 outline-none focus:ring-2 focus:ring-indigo-400"
                            required>
                    </div>

                    <!-- ROLE -->
                    <div class="mb-4 relative">
                        <select name="role"
                            class="w-full mt-1 px-4 py-2 rounded-xl bg-gray-700 text-white border border-gray-500 outline-none focus:ring-2 focus:ring-indigo-400 appearance-none">

                            <option value="user" class="bg-white text-black">User</option>
                            <option value="admin" class="bg-white text-black">Admin</option>
                        </select>

                        <!-- ICON -->
                        <div class="absolute right-3 top-3 text-gray-300 pointer-events-none">
                            ▼
                        </div>
                    </div>

                    <!-- BUTTON -->
                    <button id="registerBtn"
                        class="w-full py-2 text-sm rounded-xl text-white bg-gradient-to-r from-indigo-500 to-blue-500 hover:scale-105 transition duration-300 shadow-lg flex justify-center items-center gap-2">

                        <span id="btnText">Register</span>

                        <!-- Spinner -->
                        <svg id="spinner" class="hidden w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>

                    </button>

                    <!-- LOGIN LINK -->
                    <div class="mt-6 text-center text-sm text-gray-300">
                        Sudah punya akun?
                        <a href="{{ route('login') }}"
                            class="ml-1 px-3 py-1 rounded-lg bg-white/10 hover:bg-white/20 text-indigo-300 transition">
                            Login
                        </a>
                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>
        document.querySelector("form").addEventListener("submit", function() {
            const btn = document.getElementById("registerBtn");
            const text = document.getElementById("btnText");
            const spinner = document.getElementById("spinner");

            text.innerText = "Processing...";
            spinner.classList.remove("hidden");

            btn.disabled = true;
            btn.classList.add("opacity-70", "cursor-not-allowed");
        });
    </script>
</body>

</html>
