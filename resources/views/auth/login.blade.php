<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Adisthana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { font-family: 'DM Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-[#F0EBE3] flex items-center justify-center p-4">

    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-[#7B1518] shadow-lg shadow-[#7B1518]/25 mb-4">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21V7a2 2 0 012-2h14a2 2 0 012 2v14M3 21h18M9 21V12h6v9"/>
                </svg>
            </div>
            <h1 class="text-[#2C1810] text-3xl font-semibold" style="font-family:'Cormorant Garamond',serif;">Adisthana</h1>
            <p class="text-[#9a8a80] text-sm mt-1">Sistem Peminjaman Fasilitas Sekolah</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl border border-[#7B1518]/10 shadow-sm p-8">

            <h2 class="text-[#2C1810] text-lg font-medium mb-6" style="font-family:'Cormorant Garamond',serif;">Masuk ke Akun</h2>

            @if($errors->any() && !session('blocked_reason'))
            <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200">
                <p class="text-red-600 text-sm">{{ $errors->first() }}</p>
            </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-[#6b5a54] text-xs uppercase tracking-widest mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-[#FAF7F2] border border-[#7B1518]/15 rounded-xl px-4 py-3 text-[#2C1810] text-sm placeholder-[#c4a898] focus:outline-none focus:border-[#7B1518]/40 focus:ring-2 focus:ring-[#7B1518]/10 transition-all duration-200"
                        placeholder="email@sekolah.com">
                </div>

                <div>
                    <label class="block text-[#6b5a54] text-xs uppercase tracking-widest mb-2">Password</label>
                    <input type="password" name="password" required
                        class="w-full bg-[#FAF7F2] border border-[#7B1518]/15 rounded-xl px-4 py-3 text-[#2C1810] text-sm placeholder-[#c4a898] focus:outline-none focus:border-[#7B1518]/40 focus:ring-2 focus:ring-[#7B1518]/10 transition-all duration-200"
                        placeholder="••••••••">
                </div>

                <button type="submit"
                    class="w-full bg-[#7B1518] hover:bg-[#9B2528] text-white font-medium py-3 px-4 rounded-xl transition-all duration-200 text-sm tracking-wide shadow-sm shadow-[#7B1518]/20 hover:shadow-md hover:shadow-[#7B1518]/25">
                    Masuk
                </button>

            </form>

        </div>

        <p class="text-center text-[#c4a898] text-xs mt-6">© {{ date('Y') }} Adisthana · Sistem Peminjaman Fasilitas Sekolah</p>

    </div>

    {{-- Popup untuk user yang diblokir --}}
    @if(session('blocked_reason'))
    <script>
        window.addEventListener('load', function() {
            Swal.fire({
                icon: 'error',
                title: '🔒 Akun Diblokir',
                html: `
                    <div class="text-left">
                        <p class="mb-3">Maaf, akun Anda tidak dapat mengakses sistem karena:</p>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-left">
                            <p class="text-red-800 text-sm">"{{ session('blocked_reason') }}"</p>
                        </div>
                        <p class="mt-4 text-sm text-gray-600">Silakan hubungi administrator jika Anda merasa ini kesalahan.</p>
                    </div>
                `,
                confirmButtonColor: '#7B1518',
                confirmButtonText: 'Mengerti',
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        });
    </script>
    @endif

</body>
</html>