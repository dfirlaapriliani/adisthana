<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>{{ $title ?? 'Dashboard' }} — Adisthana Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { 
            font-family: 'DM Sans', sans-serif; 
            background: linear-gradient(135deg, #F0EBE3 0%, #E8E0D5 100%);
            min-height: 100vh;
        }
        .brand { font-family: 'Cormorant Garamond', serif; }
        
        /* Custom scrollbar */
        nav::-webkit-scrollbar { width: 4px; }
        nav::-webkit-scrollbar-track { background: transparent; }
        nav::-webkit-scrollbar-thumb { background: rgba(123,21,24,0.15); border-radius: 2px; }
        
        /* 3D Shadow Effects */
        .shadow-3d {
            box-shadow: 
                0 20px 40px -10px rgba(0,0,0,0.15),
                0 8px 20px -5px rgba(0,0,0,0.1),
                inset 0 1px 0 rgba(255,255,255,0.5);
        }
        
        .shadow-3d-nav {
            box-shadow: 
                0 15px 30px -8px rgba(0,0,0,0.12),
                0 4px 10px -3px rgba(0,0,0,0.08),
                inset 0 1px 0 rgba(255,255,255,0.6);
        }
        
        /* Prevent body scroll when sidebar open on mobile */
        body.sidebar-open {
            overflow: hidden;
        }
    </style>
</head>
<body class="min-h-screen relative">

    {{-- Overlay Mobile - Hidden by default --}}
    <div id="sidebar-overlay" 
         class="fixed inset-0 bg-black/30 backdrop-blur-sm z-40 hidden transition-all duration-300"
         onclick="closeSidebar()">
    </div>

    @include('components.admin.sidebar')

    {{-- Main Content Area --}}
    <div class="lg:ml-[300px] min-h-screen flex flex-col px-3 md:px-4 lg:px-6 py-3 md:py-4">
        @include('components.admin.navbar')
        
        {{-- Content --}}
        <main class="flex-1 mt-3 md:mt-4">
            {{ $slot }}
        </main>
        
        <footer class="mt-6 py-4 border-t border-[#7B1518]/10">
            <p class="text-[#9a8a80] text-[10px] md:text-xs text-center">© {{ date('Y') }} Adisthana · Sistem Peminjaman Fasilitas Sekolah</p>
        </footer>
    </div>

    <script>
        // PASTIKAN sidebar hidden di mobile saat pertama load
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            // Selalu hidden di mobile saat pertama load
            if (window.innerWidth < 1024) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('sidebar-open');
            }
        });
        
        function openSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (window.innerWidth < 1024) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('sidebar-open');
            }
        }
        
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('sidebar-open');
        }
        
        // Handle resize - pastikan sidebar hidden di mobile
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                if (window.innerWidth >= 1024) {
                    // Desktop: sidebar visible, overlay hidden
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('sidebar-open');
                } else {
                    // Mobile: sidebar hidden, overlay hidden
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('sidebar-open');
                }
            }, 100);
        });
        
        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && window.innerWidth < 1024) {
                closeSidebar();
            }
        });
        
        // Close sidebar when clicking on a link (mobile only)
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const isLink = e.target.closest('a');
            const isSidebar = e.target.closest('#sidebar');
            
            if (window.innerWidth < 1024 && isLink && isSidebar && !e.target.closest('button')) {
                // Small delay to allow link navigation
                setTimeout(() => {
                    closeSidebar();
                }, 150);
            }
        });
    </script>

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