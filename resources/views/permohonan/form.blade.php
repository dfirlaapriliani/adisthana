<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Akun - Adisthana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #F0EBE3; font-family: 'DM Sans', sans-serif; min-height: 100vh; display: grid; place-items: center; padding: 24px; }
        h1 { font-family: 'Cormorant Garamond', serif; font-size: 2rem; color: #7B1518; text-align: center; margin-bottom: 20px; }
        .card { background: white; border-radius: 16px; padding: 28px 32px; width: min(680px, 100%); border: 1px solid #E5D9C8; display: flex; flex-direction: column; gap: 14px; }
        .row { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; }
        label { display: block; font-size: 11px; font-weight: 600; color: #7B1518; margin-bottom: 5px; letter-spacing: 0.04em; text-transform: uppercase; }
        input, textarea { width: 100%; padding: 9px 13px; border-radius: 9px; border: 1.5px solid #E5D9C8; font-size: 13px; font-family: 'DM Sans', sans-serif; color: #3B2A1A; background: #FDFAF7; }
        input:focus, textarea:focus { border-color: #7B1518; outline: none; }
        textarea { height: 78px; resize: none; }
        .footer { display: flex; align-items: center; justify-content: space-between; }
        a { font-size: 12px; color: #A0896B; text-decoration: none; }
        button { background: #7B1518; color: white; border: none; padding: 10px 26px; border-radius: 9px; font-size: 13px; font-weight: 600; cursor: pointer; }
        button:hover { background: #691215; }
        .error { color: #dc2626; font-size: 12px; margin-top: 4px; }
        @media (max-width: 600px) { .row { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div style="width: 100%; max-width: 680px;">
        <h1>Adisthana</h1>
        <div class="card">
            <form action="{{ route('permohonan.store') }}" method="POST" style="display:contents;">
                @csrf
                <div class="row">
                    <div>
                        <label>Nama Lengkap Ketua Kelas</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama Lengkap Ketua Kelas" required>
                        @error('nama') <div class="error">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label>Kelas & Wali Kelas</label>
                        <input type="text" name="kelas" value="{{ old('kelas') }}" placeholder="XII IPA 3 - Ibu Kaita" required>
                        @error('kelas') <div class="error">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label>No WhatsApp</label>
                        <input type="tel" name="no_whatsapp" value="{{ old('no_whatsapp') }}" placeholder="08123456789" required>
                        @error('no_whatsapp') <div class="error">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div>
                    <label>Keperluan</label>
                    <textarea name="keperluan" placeholder="Jelaskan keperluan Anda..." required>{{ old('keperluan') }}</textarea>
                    @error('keperluan') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="footer">
                    <a href="{{ url('/') }}">← Kembali ke Beranda</a>
                    <button type="submit">Ajukan Permohonan</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>