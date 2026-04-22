<x-layout-admin>
    <x-slot name="title">Permohonan Akun</x-slot>
    
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-[#2C1810]" style="font-family: 'Cormorant Garamond', serif;">Permohonan Akun</h1>
        <p class="text-[#9a8a80] text-sm mt-1">Daftar permohonan akun yang masuk dari calon peminjam</p>
    </div>

    {{-- Stats Summary --}}
    @php
        $totalPending = $requests->where('status', 'pending')->count();
        $totalApproved = $requests->where('status', 'approved')->count();
        $totalRejected = $requests->where('status', 'rejected')->count();
    @endphp
    
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-[#7B1518]/10 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[#9a8a80] uppercase tracking-wider">Pending</p>
                    <p class="text-2xl font-semibold text-[#2C1810]">{{ $totalPending }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-[#7B1518]/10 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[#9a8a80] uppercase tracking-wider">Disetujui</p>
                    <p class="text-2xl font-semibold text-[#2C1810]">{{ $totalApproved }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-[#7B1518]/10 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[#9a8a80] uppercase tracking-wider">Ditolak</p>
                    <p class="text-2xl font-semibold text-[#2C1810]">{{ $totalRejected }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-[#7B1518]/10 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#F0EBE3]/50 border-b border-[#7B1518]/10">
                    <tr class="text-left">
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">No WhatsApp</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Keperluan</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#7B1518]/5">
                    @forelse($requests as $req)
                    <tr class="hover:bg-[#F0EBE3]/30 transition">
                        {{-- Nama --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#7B1518]/10 flex items-center justify-center">
                                    <span class="text-[#7B1518] text-xs font-semibold">{{ strtoupper(substr($req->nama, 0, 1)) }}</span>
                                </div>
                                <span class="text-sm font-medium text-[#2C1810]">{{ $req->nama }}</span>
                            </div>
                        </td>
                        
                        {{-- Kelas --}}
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#7B1518]/5 text-[#7B1518]">
                                {{ $req->kelas }}
                            </span>
                        </td>
                        
                        {{-- No WhatsApp --}}
                        <td class="px-6 py-4 text-sm text-[#2C1810]">{{ $req->no_whatsapp }}</td>
                        
                        {{-- Keperluan --}}
                        <td class="px-6 py-4">
                            <div class="max-w-xs">
                                <p class="text-sm text-[#2C1810] truncate" title="{{ $req->keperluan }}">
                                    {{ Str::limit($req->keperluan, 40) }}
                                </p>
                            </div>
                        </td>
                        
                        {{-- Status --}}
                        <td class="px-6 py-4">
                            @if($req->status == 'pending')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Pending
                                </span>
                            @elseif($req->status == 'approved')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Disetujui
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Ditolak
                                </span>
                            @endif
                        </td>
                        
                        {{-- Tanggal --}}
                        <td class="px-6 py-4 text-sm text-[#6b5a54]">
                            {{ $req->created_at->format('d M Y') }}
                            <span class="block text-xs text-[#9a8a80]">{{ $req->created_at->format('H:i') }}</span>
                        </td>
                        
                        {{-- Aksi --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1">
                                @if($req->status == 'pending')
                                    {{-- Setujui --}}
                                    <form action="{{ route('admin.account-requests.setujui', $req->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="p-2 rounded-lg text-green-600 hover:text-white hover:bg-green-600 transition"
                                                onclick="return confirm('Setujui permohonan ini?')"
                                                title="Setujui">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                    </form>
                                    
                                    {{-- Buat Akun Langsung --}}
                                    <a href="{{ route('admin.users.create', ['from' => 'permohonan', 'nama' => $req->nama, 'kelas' => $req->kelas, 'phone' => $req->no_whatsapp]) }}" 
                                       class="p-2 rounded-lg text-blue-600 hover:text-white hover:bg-blue-600 transition"
                                       title="Buat Akun Langsung">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </a>
                                    
                                    {{-- Tolak --}}
                                    <form action="{{ route('admin.account-requests.tolak', $req->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="p-2 rounded-lg text-red-600 hover:text-white hover:bg-red-600 transition"
                                                onclick="return confirm('Tolak permohonan ini?')"
                                                title="Tolak">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[#9a8a80] text-sm">-</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-[#F0EBE3] flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-[#9a8a80]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                </div>
                                <p class="text-[#2C1810] font-medium">Belum ada permohonan akun</p>
                                <p class="text-[#9a8a80] text-sm mt-1">Permohonan akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        {{-- @if($requests->hasPages())
        <div class="px-6 py-4 border-t border-[#7B1518]/10">
            {{ $requests->links() }}
        </div>
        @endif --}}
    </div>
</x-layout-admin>