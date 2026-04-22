<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Akun - Adisthana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
</head>
<body class="font-['DM_Sans']" style="background-color: #F0EBE3;">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="text-center font-['Cormorant_Garamond'] text-4xl font-bold" style="color: #7B1518;">
                    Adisthana
                </h2>
                <p class="mt-2 text-center text-gray-600">
                    Permohonan Akun Peminjaman Buku
                </p>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-8">
                <form action="{{ route('permohonan.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" required 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#7B1518] focus:ring focus:ring-[#7B1518] focus:ring-opacity-20"
                               value="{{ old('nama') }}">
                        @error('nama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
                        <input type="text" name="kelas" id="kelas" required 
                               placeholder="Contoh: XII IPA 3"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#7B1518] focus:ring focus:ring-[#7B1518] focus:ring-opacity-20"
                               value="{{ old('kelas') }}">
                        @error('kelas')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="no_whatsapp" class="block text-sm font-medium text-gray-700">No WhatsApp</label>
                        <input type="text" name="no_whatsapp" id="no_whatsapp" required 
                               placeholder="Contoh: 08123456789"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#7B1518] focus:ring focus:ring-[#7B1518] focus:ring-opacity-20"
                               value="{{ old('no_whatsapp') }}">
                        @error('no_whatsapp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="keperluan" class="block text-sm font-medium text-gray-700">Keperluan</label>
                        <textarea name="keperluan" id="keperluan" rows="4" required 
                                  placeholder="Jelaskan keperluan Anda meminjam buku..."
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#7B1518] focus:ring focus:ring-[#7B1518] focus:ring-opacity-20">{{ old('keperluan') }}</textarea>
                        @error('keperluan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#7B1518]"
                                style="background-color: #7B1518;">
                            Ajukan Permohonan
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ url('/') }}" class="text-sm text-gray-600 hover:text-[#7B1518]">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>