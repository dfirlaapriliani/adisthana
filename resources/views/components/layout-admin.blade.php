<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} — Adisthana Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { font-family: 'DM Sans', sans-serif; background-color: #F0EBE3; }
        .brand { font-family: 'Cormorant Garamond', serif; }
        nav::-webkit-scrollbar { width: 4px; }
        nav::-webkit-scrollbar-track { background: transparent; }
        nav::-webkit-scrollbar-thumb { background: rgba(123,21,24,0.15); border-radius: 2px; }
    </style>
</head>
<body class="bg-[#F0EBE3] min-h-screen">

    @include('components.admin.sidebar')

    <div class="lg:pl-64 min-h-screen flex flex-col">
        @include('components.admin.navbar')
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
        <footer class="px-6 py-4 border-t border-[#7B1518]/10">
            <p class="text-[#9a8a80] text-xs text-center">© {{ date('Y') }} Adisthana · Sistem Peminjaman Fasilitas Sekolah</p>
        </footer>
    </div>

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/20 z-30 hidden lg:hidden"
        onclick="document.getElementById('sidebar').classList.add('-translate-x-full'); this.classList.add('hidden')">
    </div>

    {{-- Flash Message SweetAlert --}}
    @if(session('swal'))
    <script>
        Swal.fire({
            icon: '{{ session('swal')['icon'] }}',
            title: '{{ session('swal')['title'] }}',
            text: '{{ session('swal')['text'] ?? '' }}',
            confirmButtonColor: '#7B1518',
            timer: 3000,
            timerProgressBar: true
        });
    </script>
    @endif

</body>
</html>