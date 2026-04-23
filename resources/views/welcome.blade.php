<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Adisthana - Sistem Peminjaman Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#7B1518', light: '#9B2226' },
                        cream: { DEFAULT: '#F5F0EA', dark: '#EDE6DC' },
                        brown: { DEFAULT: '#2C1810' },
                    },
                    fontFamily: {
                        serif: ['Cormorant Garamond', 'serif'],
                        sans: ['DM Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        
        .bg-grid-pattern {
            background-image: 
                linear-gradient(to right, rgba(123, 21, 24, 0.08) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(123, 21, 24, 0.08) 1px, transparent 1px);
            background-size: 50px 50px;
        }
        
        .navbar-floating {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-radius: 2rem;
            margin: 1rem 1rem;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.2), 0 1px 2px 0 rgba(255, 255, 255, 0.3) inset, 0 -1px 2px 0 rgba(0, 0, 0, 0.05) inset;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }
        
        .navbar-floating:hover {
            transform: translateY(-3px);
            box-shadow: 0 28px 45px -15px rgba(0, 0, 0, 0.25), 0 1px 3px 0 rgba(255, 255, 255, 0.4) inset;
        }
        
        .btn-3d {
            transition: all 0.2s ease;
            box-shadow: 0 4px 0 #4a0e10;
        }
        .btn-3d:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 #4a0e10;
        }
        
        .btn-outline-3d {
            background: transparent;
            border: 2px solid #7B1518;
            transition: all 0.2s ease;
            box-shadow: 0 3px 0 #7B1518;
        }
        .btn-outline-3d:active {
            transform: translateY(2px);
            box-shadow: 0 1px 0 #7B1518;
        }
        .btn-outline-3d:hover {
            background: #7B1518;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 0 #4a0e10;
        }
        
        @keyframes floatImage {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-12px) rotate(1deg); }
        }
        .image-float {
            animation: floatImage 4s ease-in-out infinite;
        }
        
        @media (max-width: 768px) {
            .navbar-floating { margin: 0.75rem; border-radius: 1.5rem; }
        }
        
        .step-card {
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }
        .step-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.15);
        }
        
        html { scroll-behavior: smooth; }

        .mobile-menu-item {
            padding: 0.875rem 1rem;
            border-radius: 1rem;
            transition: all 0.2s ease;
        }
        .mobile-menu-item:hover {
            background-color: #7B1518;
            color: white !important;
        }
        .mobile-menu-item:hover i { color: white !important; }
        
        .hero-section {
            min-height: calc(100vh - 70px);
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body class="bg-cream text-brown overflow-x-hidden bg-grid-pattern">

    <!-- NAVBAR -->
    <nav class="fixed top-0 left-0 right-0 z-50">
        <div class="navbar-floating">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-2.5 sm:py-3 flex items-center justify-between">
                <a href="#" class="flex items-center gap-2 no-underline">
                    <i class="fas fa-book-open text-primary text-lg sm:text-xl"></i>
                    <span class="font-serif text-lg sm:text-xl font-bold text-primary tracking-wide">Adisthana</span>
                </a>
                
                <ul class="hidden md:flex items-center gap-4 lg:gap-5 list-none m-0 p-0">
                    <li><a href="#home" class="text-primary font-semibold text-sm no-underline hover:opacity-80 transition">Home</a></li>
                    <li><a href="#cara-kerja" class="text-gray-500 hover:text-primary text-sm font-medium transition-colors no-underline">Cara Kerja</a></li>
                    <li><a href="#fitur" class="text-gray-500 hover:text-primary text-sm font-medium transition-colors no-underline">Fitur</a></li>
                </ul>
                
                <div class="hidden md:flex items-center gap-2">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn-3d bg-primary hover:bg-primary-light text-white text-xs font-semibold px-3 py-1.5 rounded-xl transition-all no-underline flex items-center gap-1"><i class="fas fa-chalkboard-user"></i> Dashboard</a>
                        @else
                            <a href="{{ route('peminjam.dashboard') }}" class="btn-3d bg-primary hover:bg-primary-light text-white text-xs font-semibold px-3 py-1.5 rounded-xl transition-all no-underline flex items-center gap-1"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline m-0">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-primary text-xs font-medium transition-colors bg-transparent border-0 cursor-pointer flex items-center gap-1"><i class="fas fa-sign-out-alt"></i> Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-outline-3d text-primary text-xs font-semibold px-4 py-1.5 rounded-xl transition-all no-underline flex items-center gap-1"><i class="fas fa-key"></i> Login</a>
                    @endauth
                </div>
                
                <div class="md:hidden">
                    <button id="mobileMenuBtn" class="text-primary text-2xl focus:outline-none p-1"><i class="fas fa-bars"></i></button>
                </div>
            </div>
            
            <div id="mobileMenu" class="hidden md:hidden bg-white/98 backdrop-blur-md rounded-2xl mt-2 mx-4 mb-3 p-4 shadow-2xl">
                <div class="mb-5 border-b border-gray-200 pb-3">
                    <div class="text-xs text-gray-400 uppercase tracking-wider mb-2 px-2">Menu</div>
                    <ul class="flex flex-col gap-1 list-none m-0 p-0">
                        <li><a href="#home" class="mobile-menu-item text-primary font-semibold text-base no-underline flex items-center gap-3"><i class="fas fa-home w-5"></i> Home</a></li>
                        <li><a href="#cara-kerja" class="mobile-menu-item text-gray-600 hover:text-white text-base font-medium flex items-center gap-3"><i class="fas fa-stairs w-5"></i> Cara Kerja</a></li>
                        <li><a href="#fitur" class="mobile-menu-item text-gray-600 hover:text-white text-base font-medium flex items-center gap-3"><i class="fas fa-star w-5"></i> Fitur</a></li>
                    </ul>
                </div>
                <div>
                    <div class="text-xs text-gray-400 uppercase tracking-wider mb-2 px-2">Akun</div>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="mobile-menu-item bg-primary text-white text-base font-semibold rounded-xl flex items-center gap-3 mb-2"><i class="fas fa-chalkboard-user w-5"></i> Dashboard Admin</a>
                        @else
                            <a href="{{ route('peminjam.dashboard') }}" class="mobile-menu-item bg-primary text-white text-base font-semibold rounded-xl flex items-center gap-3 mb-2"><i class="fas fa-tachometer-alt w-5"></i> Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline m-0 w-full">
                            @csrf
                            <button type="submit" class="mobile-menu-item text-gray-600 hover:text-white text-base font-medium w-full text-left flex items-center gap-3"><i class="fas fa-sign-out-alt w-5"></i> Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="mobile-menu-item btn-outline-3d text-primary text-base font-semibold rounded-xl flex items-center gap-3 mb-2 justify-center"><i class="fas fa-key"></i> Login</a>
                        <a href="{{ route('permohonan.create') }}" class="mobile-menu-item btn-3d bg-primary text-white text-base font-semibold rounded-xl flex items-center gap-3 justify-center"><i class="fas fa-user-plus"></i> Ajukan Akun</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="h-14 sm:h-16"></div>

    <!-- HERO -->
    <section id="home" class="hero-section max-w-7xl mx-auto px-5 sm:px-6 py-6 sm:py-8 flex flex-col lg:flex-row items-center gap-6 lg:gap-10">
        <div class="flex-1 text-center lg:text-left">
            <div class="inline-flex items-center gap-2 bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider px-3 py-1.5 rounded-full mb-4 lg:mb-5 mx-auto lg:mx-0">
                <i class="fas fa-graduation-cap text-xs"></i>
                <span>Sistem Perpustakaan Digital</span>
            </div>

            <h1 class="font-serif text-4xl sm:text-5xl lg:text-7xl font-bold leading-[1.1] text-brown mb-3 lg:mb-5 tracking-tight">
                Ruang Temu,<br>
                <span class="text-primary">Awal Karya.</span>
            </h1>

            <p class="text-sm sm:text-base lg:text-lg text-gray-500 leading-relaxed mb-5 lg:mb-8 max-w-md mx-auto lg:mx-0 hidden lg:block">
                Platform peminjaman buku sekolah yang mudah, cepat, dan terpantau.
            </p>
            <p class="text-xs text-gray-400 leading-relaxed mb-5 max-w-xs mx-auto lg:hidden">
                Platform peminjaman buku sekolah yang mudah, cepat, dan terpantau.
            </p>

            <div class="flex gap-3 justify-center lg:justify-start flex-wrap">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn-3d bg-primary text-white px-5 sm:px-7 py-2.5 sm:py-3.5 rounded-xl text-xs sm:text-sm lg:text-base font-semibold shadow-lg hover:shadow-xl transition-all no-underline inline-flex items-center gap-2"><i class="fas fa-chalkboard-user"></i> Dashboard →</a>
                    @else
                        <a href="{{ route('peminjam.dashboard') }}" class="btn-3d bg-primary text-white px-5 sm:px-7 py-2.5 sm:py-3.5 rounded-xl text-xs sm:text-sm lg:text-base font-semibold shadow-lg hover:shadow-xl transition-all no-underline inline-flex items-center gap-2"><i class="fas fa-tachometer-alt"></i> Dashboard →</a>
                    @endif
                @else
                    <a href="{{ route('permohonan.create') }}" class="btn-3d bg-primary text-white px-5 sm:px-7 py-2.5 sm:py-3.5 rounded-xl text-xs sm:text-sm lg:text-base font-semibold shadow-lg hover:shadow-xl transition-all no-underline inline-flex items-center gap-2"><i class="fas fa-user-plus"></i> Ajukan Akun</a>
                    <a href="{{ route('login') }}" class="btn-outline-3d text-primary px-5 sm:px-7 py-2.5 sm:py-3.5 rounded-xl text-xs sm:text-sm lg:text-base font-semibold transition-all no-underline inline-flex items-center gap-2"><i class="fas fa-key"></i> Login</a>
                @endauth
            </div>
        </div>

        <div class="hidden lg:flex flex-1 justify-center items-center">
            <img src="{{ asset('assets_public/adist.png') }}" alt="Adisthana" class="image-float w-full max-w-[600px] lg:max-w-[750px] xl:max-w-[900px] object-contain drop-shadow-2xl">
        </div>
    </section>

    <!-- TATA CARA -->
    <section id="cara-kerja" class="py-12 sm:py-20 bg-cream-dark">
        <div class="max-w-6xl mx-auto px-5 sm:px-6">
            <div class="text-center mb-10 sm:mb-16">
                <div class="inline-flex items-center gap-2 bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider px-3 py-1.5 rounded-full mb-4 mx-auto"><i class="fas fa-stairs"></i><span>Tata Cara</span></div>
                <h2 class="font-serif text-3xl sm:text-5xl font-bold text-brown mb-3">Mulai dalam 3 Langkah</h2>
                <p class="text-sm sm:text-lg text-gray-500 max-w-xl mx-auto">Proses simpel & cepat, dari pendaftaran hingga pengembalian buku.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-8">
                <div class="step-card bg-white rounded-2xl p-6 sm:p-8 text-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mx-auto mb-4 sm:mb-6"><i class="fas fa-file-alt text-3xl sm:text-4xl"></i></div>
                    <h3 class="font-bold text-xl sm:text-2xl text-brown mb-2">Ajukan Akun</h3>
                    <p class="text-gray-500 text-sm sm:text-base">Isi formulir permohonan akun. Tunggu persetujuan admin.</p>
                </div>
                <div class="step-card bg-white rounded-2xl p-6 sm:p-8 text-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mx-auto mb-4 sm:mb-6"><i class="fas fa-search text-3xl sm:text-4xl"></i></div>
                    <h3 class="font-bold text-xl sm:text-2xl text-brown mb-2">Cari & Pilih Buku</h3>
                    <p class="text-gray-500 text-sm sm:text-base">Telusuri koleksi buku dan ajukan peminjaman.</p>
                </div>
                <div class="step-card bg-white rounded-2xl p-6 sm:p-8 text-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mx-auto mb-4 sm:mb-6"><i class="fas fa-book text-3xl sm:text-4xl"></i></div>
                    <h3 class="font-bold text-xl sm:text-2xl text-brown mb-2">Pinjam & Kembalikan</h3>
                    <p class="text-gray-500 text-sm sm:text-base">Ambil buku di perpustakaan dan kembalikan tepat waktu.</p>
                </div>
            </div>
            <div class="mt-8 sm:mt-10 bg-white/70 rounded-xl p-4 text-center">
                <p class="text-sm sm:text-base text-brown font-medium"><i class="fas fa-info-circle mr-2"></i> Maksimal 3 buku · Durasi 7 hari · Bisa perpanjang 1x (3 hari)</p>
            </div>
        </div>
    </section>

    <!-- FITUR -->
    <section id="fitur" class="py-12 sm:py-20">
        <div class="max-w-6xl mx-auto px-5 sm:px-6">
            <div class="text-center mb-10 sm:mb-16">
                <div class="inline-flex items-center gap-2 bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider px-3 py-1.5 rounded-full mb-4 mx-auto"><i class="fas fa-crown"></i><span>Fitur Unggulan</span></div>
                <h2 class="font-serif text-3xl sm:text-5xl font-bold text-brown mb-3">Lebih dari Sekadar<br>Peminjaman</h2>
                <p class="text-sm sm:text-lg text-gray-500 max-w-xl mx-auto">Nikmati kemudahan mengelola aktivitas literasi di sekolah.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                <div class="text-center p-4"><div class="text-5xl sm:text-6xl mb-4 text-primary"><i class="fas fa-chart-line"></i></div><h4 class="font-bold text-xl sm:text-2xl text-brown mb-2">Dashboard Real-time</h4><p class="text-gray-500 text-sm sm:text-base">Lihat status peminjaman, histori, dan denda.</p></div>
                <div class="text-center p-4"><div class="text-5xl sm:text-6xl mb-4 text-primary"><i class="fas fa-magnifying-glass"></i></div><h4 class="font-bold text-xl sm:text-2xl text-brown mb-2">Pencarian Buku</h4><p class="text-gray-500 text-sm sm:text-base">Temukan buku berdasarkan judul, penulis, kategori.</p></div>
                <div class="text-center p-4"><div class="text-5xl sm:text-6xl mb-4 text-primary"><i class="fas fa-file-excel"></i></div><h4 class="font-bold text-xl sm:text-2xl text-brown mb-2">Laporan Otomatis</h4><p class="text-gray-500 text-sm sm:text-base">Admin ekspor data peminjaman & buku terpopuler.</p></div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-12 sm:py-20 bg-cream-dark">
        <div class="max-w-2xl mx-auto px-5 sm:px-6 text-center">
            <div class="inline-flex items-center gap-2 bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider px-3 py-1.5 rounded-full mb-4 mx-auto"><i class="fas fa-users"></i><span>Bergabung Sekarang</span></div>
            <h2 class="font-serif text-3xl sm:text-5xl font-bold text-brown mb-3 leading-tight">Siap Mulai Membaca?</h2>
            <p class="text-sm sm:text-lg text-gray-500 mb-6">Daftarkan akun kamu dan nikmati akses ke ribuan koleksi buku.</p>
            <div class="flex gap-3 justify-center flex-wrap">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn-3d bg-primary text-white px-5 sm:px-7 py-2.5 sm:py-3.5 rounded-xl text-xs sm:text-base font-semibold inline-flex items-center gap-2"><i class="fas fa-chalkboard-user"></i> Dashboard →</a>
                    @else
                        <a href="{{ route('peminjam.dashboard') }}" class="btn-3d bg-primary text-white px-5 sm:px-7 py-2.5 sm:py-3.5 rounded-xl text-xs sm:text-base font-semibold inline-flex items-center gap-2"><i class="fas fa-tachometer-alt"></i> Dashboard →</a>
                    @endif
                @else
                    <a href="{{ route('permohonan.create') }}" class="btn-3d bg-primary text-white px-5 sm:px-7 py-2.5 sm:py-3.5 rounded-xl text-xs sm:text-base font-semibold inline-flex items-center gap-2"><i class="fas fa-user-plus"></i> Ajukan Akun</a>
                    <a href="{{ route('login') }}" class="btn-outline-3d text-primary px-5 sm:px-7 py-2.5 sm:py-3.5 rounded-xl text-xs sm:text-base font-semibold inline-flex items-center gap-2"><i class="fas fa-key"></i> Login</a>
                @endauth
            </div>
        </div>
    </section>

    <footer class="bg-brown py-8 text-center">
        <div class="max-w-6xl mx-auto px-5 sm:px-6 flex flex-col items-center gap-2">
            <div class="flex items-center gap-2"><i class="fas fa-book-open text-white text-xl"></i><div class="font-serif text-xl font-bold text-white">Adisthana</div></div>
            <div class="text-sm italic text-white/40">Landasan Ilmu, Pijakan Prestasi</div>
            <div class="text-xs text-white/30">© {{ date('Y') }} Adisthana · Sistem Peminjaman Buku Perpustakaan Sekolah</div>
        </div>
    </footer>

    <script>
        const menuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => { mobileMenu.classList.toggle('hidden'); });
            mobileMenu.querySelectorAll('a, button').forEach(link => {
                link.addEventListener('click', () => { mobileMenu.classList.add('hidden'); });
            });
        }
    </script>
</body>
</html>