<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adisthana - Sistem Peminjaman Buku</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cormorant-garamond:400,600,700|dm-sans:400,500" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #F0EBE3;
            font-family: 'DM Sans', sans-serif;
        }
        h1, h2 {
            font-family: 'Cormorant Garamond', serif;
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col">
        {{-- Header --}}
        <header class="bg-white/80 backdrop-blur-sm shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold" style="color: #7B1518; font-family: 'Cormorant Garamond', serif;">
                        📚 Adisthana
                    </h1>
                    <nav class="flex items-center gap-4">
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="px-4 py-2 rounded-lg text-white text-sm font-medium"
                                   style="background-color: #7B1518;">
                                    Dashboard Admin
                                </a>
                            @else
                                <a href="{{ route('peminjam.dashboard') }}" 
                                   class="px-4 py-2 rounded-lg text-white text-sm font-medium"
                                   style="background-color: #7B1518;">
                                    Dashboard Peminjam
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-gray-900">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" 
                               class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-gray-900">
                                Login
                            </a>
                            <a href="{{ route('permohonan.create') }}" 
                               class="px-4 py-2 rounded-lg text-white text-sm font-medium"
                               style="background-color: #7B1518;">
                                Ajukan Akun
                            </a>
                        @endauth
                    </nav>
                </div>
            </div>
        </header>

        {{-- Hero Section --}}
        <main class="flex-1 flex items-center justify-center py-16 px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="mb-8">
                    <span class="inline-block px-4 py-1.5 rounded-full text-sm font-medium mb-4"
                          style="background-color: #7B1518; color: white;">
                        Selamat Datang
                    </span>
                    <h1 class="text-5xl md:text-6xl font-bold mb-6" style="color: #2C1810; font-family: 'Cormorant Garamond', serif;">
                        Sistem Peminjaman Buku<br>Perpustakaan Sekolah
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                        Pinjam buku dengan mudah, pantau status peminjaman, dan kelola akun kelas dalam satu platform.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" 
                               class="px-8 py-4 rounded-xl text-white text-lg font-medium shadow-lg hover:shadow-xl transition-all"
                               style="background-color: #7B1518;">
                                Masuk Dashboard Admin
                            </a>
                        @else
                            <a href="{{ route('peminjam.dashboard') }}" 
                               class="px-8 py-4 rounded-xl text-white text-lg font-medium shadow-lg hover:shadow-xl transition-all"
                               style="background-color: #7B1518;">
                                Masuk Dashboard Peminjam
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-8 py-4 rounded-xl bg-white border-2 text-lg font-medium hover:shadow-lg transition-all"
                           style="border-color: #7B1518; color: #7B1518;">
                            Login
                        </a>
                        <a href="{{ route('permohonan.create') }}" 
                           class="px-8 py-4 rounded-xl text-white text-lg font-medium shadow-lg hover:shadow-xl transition-all"
                           style="background-color: #7B1518;">
                            Ajukan Akun Baru
                        </a>
                    @endauth
                </div>

                {{-- Features --}}
                <div class="grid md:grid-cols-3 gap-6 mt-16">
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <div class="text-3xl mb-3">📚</div>
                        <h3 class="font-semibold text-lg mb-2" style="color: #2C1810;">Koleksi Buku Lengkap</h3>
                        <p class="text-gray-600 text-sm">Akses berbagai buku pelajaran dan bacaan untuk menunjang pembelajaran.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <div class="text-3xl mb-3">⏰</div>
                        <h3 class="font-semibold text-lg mb-2" style="color: #2C1810;">Peminjaman Mudah</h3>
                        <p class="text-gray-600 text-sm">Ajukan peminjaman online dan pantau statusnya secara real-time.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <div class="text-3xl mb-3">👥</div>
                        <h3 class="font-semibold text-lg mb-2" style="color: #2C1810;">Akun Kelas</h3>
                        <p class="text-gray-600 text-sm">Satu akun untuk satu kelas, memudahkan pengelolaan peminjaman.</p>
                    </div>
                </div>
            </div>
        </main>

        {{-- Footer --}}
        <footer class="py-6 text-center text-sm text-gray-500 border-t border-gray-200">
            <p>© 2026 Adisthana · Sistem Peminjaman Buku Sekolah</p>
        </footer>
    </div>
</body>
</html>