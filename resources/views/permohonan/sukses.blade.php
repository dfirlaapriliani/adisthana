<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Terkirim - Adisthana</title>
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
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="mb-6">
                    <svg class="mx-auto h-16 w-16" style="color: #7B1518;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Permohonan Terkirim!</h3>
                
                <p class="text-gray-600 mb-6">
                    Terima kasih telah mengajukan permohonan akun.<br>
                    Mohon tunggu konfirmasi dari admin melalui WhatsApp.
                </p>
                
                <div class="border-t border-gray-200 pt-6">
                    <a href="{{ url('/') }}" 
                       class="inline-flex justify-center py-2 px-6 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:opacity-90"
                       style="background-color: #7B1518;">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>