{{-- resources/views/layouts/peminjam.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>{{ $title ?? 'Dashboard' }} — Adisthana</title>
    
    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { 
            font-family: 'DM Sans', sans-serif; 
            background-color: #FFF9F0;
        }
        .brand { 
            font-family: 'Cormorant Garamond', serif; 
        }
        
        /* Custom scrollbar */
        nav::-webkit-scrollbar { 
            width: 4px; 
        }
        nav::-webkit-scrollbar-track { 
            background: transparent; 
        }
        nav::-webkit-scrollbar-thumb { 
            background: #C75B39; 
            border-radius: 2px; 
        }
        
        /* Line clamp utility */
        .line-clamp-1 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 1;
        }
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }
        
        /* Mobile sidebar open state */
        .sidebar-open {
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-[#FFF9F0] min-h-screen antialiased">

    {{-- Include Sidebar --}}
    @include('components.peminjam.sidebar')

    {{-- Main Content Wrapper --}}
    <div class="lg:pl-64 min-h-screen flex flex-col">
        {{-- Include Navbar --}}
        @include('components.peminjam.navbar')
        
        {{-- Main Content --}}
        <main class="flex-1 p-4 sm:p-6">
            {{ $slot }}
        </main>
        
        {{-- Footer --}}
        <footer class="px-4 sm:px-6 py-4 border-t-2 border-[#C75B39]/20">
            <p class="text-[#8B3A3A] text-xs text-center font-medium">
                © {{ date('Y') }} Adisthana · Sistem Peminjaman Fasilitas Sekolah
            </p>
        </footer>
    </div>

    {{-- Mobile Sidebar Overlay --}}
    <div id="sidebar-overlay" 
         class="fixed inset-0 bg-[#4A1C1C]/60 z-30 hidden lg:hidden backdrop-blur-sm transition-opacity" 
         onclick="closeSidebar()">
    </div>

    {{-- Global JavaScript --}}
    <script>
        // Toggle Sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (sidebar && overlay) {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
                document.body.classList.toggle('sidebar-open');
            }
        }
        
        // Close Sidebar
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (sidebar && overlay) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('sidebar-open');
            }
        }
        
        // Close sidebar on window resize (if desktop)
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                if (sidebar && overlay) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('sidebar-open');
                }
            }
        });
        
        // Close sidebar with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSidebar();
            }
        });
    </script>

    {{-- SweetAlert Flash Messages --}}
    @if(session('swal'))
    <script>
        Swal.fire({
            icon: '{{ session('swal')['icon'] }}',
            title: '{{ session('swal')['title'] }}',
            text: '{{ session('swal')['text'] ?? '' }}',
            confirmButtonColor: '#C75B39',
            background: '#FFF9F0',
            color: '#4A1C1C',
            timer: 3000,
            timerProgressBar: true
        });
    </script>
    @endif

    {{-- Stack for additional scripts --}}
    @stack('scripts')
</body>
</html>