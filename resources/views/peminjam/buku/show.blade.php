{{-- resources/views/peminjam/buku/show.blade.php --}}
<x-layout-peminjam>
    <x-slot name="title">{{ $buku->judul }}</x-slot>

    {{-- Back --}}
    <div class="px-4 py-3 flex items-center gap-2">
        <a href="{{ route('peminjam.buku.index') }}" class="text-[#8B5E3C] text-sm flex items-center gap-1.5 hover:text-[#C87A5A] transition">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Hero --}}
    <div class="grid border-y border-[#C87A5A]/15" style="grid-template-columns: 140px 1fr">
        {{-- Cover - portrait 3:4 --}}
        <div class="bg-[#FDE8D0] relative overflow-hidden" style="aspect-ratio: 3/4">
            @if($buku->foto)
                <img src="{{ asset('storage/' . $buku->foto) }}" class="w-full h-full object-cover absolute inset-0">
            @else
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-9 h-9 stroke-[#C87A5A]/30" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                    </svg>
                </div>
            @endif
            <span class="absolute top-2 left-2 bg-green-100 text-green-700 border border-green-300 text-[10px] font-semibold px-2 py-0.5 rounded-full">
                Tersedia
            </span>
        </div>

        {{-- Info --}}
        <div class="bg-[#FFF5E8] border-l border-[#C87A5A]/15 px-4 py-5 flex flex-col justify-between">
            <div class="flex flex-col gap-1">
                @if($buku->kategori)
                    <span class="text-[10px] text-[#C87A5A] uppercase tracking-widest font-medium">{{ $buku->kategori->nama }}</span>
                @endif
                <h1 class="text-[17px] font-bold text-[#3D2B1F] leading-tight brand">
                    {{ $buku->judul }}
                </h1>
                <p class="text-[12px] text-[#C87A5A]">{{ $buku->pengarang }}</p>
            </div>
            <div class="flex flex-col gap-1.5">
                <div class="flex justify-between text-[11px] border-b border-[#C87A5A]/10 pb-1.5">
                    <span class="text-[#8B5E3C]/60">Penerbit</span>
                    <span class="text-[#5C3A2E]">{{ $buku->penerbit }}</span>
                </div>
                <div class="flex justify-between text-[11px] border-b border-[#C87A5A]/10 pb-1.5">
                    <span class="text-[#8B5E3C]/60">Tahun</span>
                    <span class="text-[#5C3A2E]">{{ $buku->tahun_terbit }}</span>
                </div>
                <div class="flex justify-between text-[11px]">
                    <span class="text-[#8B5E3C]/60">Stok</span>
                    <span class="text-[#5C3A2E]">{{ $buku->stok }} buku</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Deskripsi + Tombol --}}
    <div class="px-4">
        @if($buku->deskripsi)
        <div class="py-4 border-b border-[#C87A5A]/15">
            <p class="text-[10px] text-[#8B5E3C]/60 uppercase tracking-widest mb-2">Deskripsi</p>
            <p class="text-[13.5px] text-[#5C3A2E] leading-[1.75]">{{ $buku->deskripsi }}</p>
        </div>
        @endif

        <div class="py-4">
            @if(!auth()->user()->hasActivePenalty())
                <a href="{{ route('peminjam.peminjaman.create', ['buku_id' => $buku->id]) }}"
                   class="flex items-center justify-center gap-2 w-full py-3.5 bg-[#C87A5A] text-white rounded-[10px] text-sm font-bold tracking-wide hover:bg-[#B86A4A] transition shadow-sm shadow-[#C87A5A]/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Ajukan Peminjaman
                </a>
            @else
                <div class="py-3 px-4 bg-red-50 border border-red-200 rounded-[10px] text-center text-red-600 text-sm">
                    Sedang dalam masa penalti
                </div>
            @endif
        </div>
    </div>
</x-layout-peminjam>