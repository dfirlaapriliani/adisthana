<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} — Adisthana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .brand { font-family: 'Cormorant Garamond', serif; }
        nav::-webkit-scrollbar { width: 4px; }
        nav::-webkit-scrollbar-track { background: transparent; }
        nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.06); border-radius: 2px; }
    </style>
</head>
<body class="bg-[#0e0e10] min-h-screen">

    @include('components.peminjam.sidebar')

    <div class="lg:pl-64 min-h-screen flex flex-col">
        @include('components.peminjam.navbar')
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
        <footer class="px-6 py-4 border-t border-white/[0.04]">
            <p class="text-[#3d3d45] text-xs text-center">© {{ date('Y') }} Adisthana · Sistem Peminjaman Fasilitas Sekolah</p>
        </footer>
    </div>

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" 
        onclick="document.getElementById('sidebar').classList.add('-translate-x-full'); this.classList.add('hidden')">
    </div>

    {{-- Flash Message SweetAlert --}}
    @if(session('swal'))
    <script>
        Swal.fire({
            icon: '{{ session('swal')['icon'] }}',
            title: '{{ session('swal')['title'] }}',
            text: '{{ session('swal')['text'] ?? '' }}',
            confirmButtonColor: '#d4af6a',
            background: '#111114',
            color: '#fff',
            timer: 3000,
            timerProgressBar: true
        });
    </script>
    @endif

</body>
</html>