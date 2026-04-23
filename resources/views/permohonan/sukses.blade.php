<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Terkirim - Adisthana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            background: #F0EBE3;
            font-family: 'DM Sans', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            overflow: hidden;
        }
        
        .container {
            max-width: 500px;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3rem;
            color: #7B1518;
            text-align: center;
            margin-bottom: 24px;
        }
        
        .card {
            background: white;
            padding: 40px 32px;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            text-align: center;
        }
        
        .icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 20px;
            color: #7B1518;
        }
        
        h2 {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 12px;
        }
        
        p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 28px;
        }
        
        .btn {
            display: inline-block;
            background: #7B1518;
            color: white;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }
        
        .btn:hover {
            background: #691215;
        }
        
        .divider {
            border-top: 1px solid #E0D8CC;
            margin: 24px 0 0;
            padding-top: 24px;
        }
        
        .back-link {
            color: #7B1518;
            text-decoration: none;
            font-size: 13px;
        }

        @media (max-width: 480px) {
            h1 { font-size: 2.5rem; }
            .card { padding: 32px 20px; }
            .icon { width: 56px; height: 56px; }
            h2 { font-size: 20px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Adisthana</h1>
        
        <div class="card">
            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            
            <h2>Permohonan Terkirim!</h2>
            
            <p>
                Terima kasih telah mengajukan permohonan akun.<br>
                Mohon tunggu konfirmasi dari admin melalui WhatsApp.
            </p>
            
            <a href="{{ url('/') }}" class="btn">Kembali ke Beranda</a>
            
            <div class="divider">
                <a href="{{ url('/') }}" class="back-link">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</body>
</html>