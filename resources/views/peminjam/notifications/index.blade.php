{{-- resources/views/peminjam/notifikasi/index.blade.php --}}
<x-layout-peminjam>
    <x-slot name="title">Notifikasi</x-slot>
    
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-[#4A1C1C] brand">Notifikasi</h1>
            <p class="text-[#8B3A3A] text-xs sm:text-sm mt-1 font-medium">Informasi dan pemberitahuan untuk Anda</p>
        </div>
        
        @php
            $unreadCount = \App\Models\UserNotification::where('user_id', auth()->id())
                ->where('is_read', false)
                ->count();
        @endphp
        @if($unreadCount > 0)
        <form action="{{ route('peminjam.notifikasi.baca-semua') }}" method="POST">
            @csrf
            <button type="submit" class="text-sm font-bold text-[#C75B39] hover:text-[#8B3A3A] hover:underline transition">
                Tandai semua sudah dibaca
            </button>
        </form>
        @endif
    </div>

    <div class="space-y-3">
        @php
            $notifications = \App\Models\UserNotification::where('user_id', auth()->id())
                ->latest()
                ->paginate(15);
        @endphp
        
        @forelse($notifications as $notif)
        <div class="bg-white border-2 rounded-xl p-4 {{ $notif->is_read ? 'border-[#C75B39]/20' : 'border-[#C75B39] shadow-md' }}">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <h3 class="text-[#4A1C1C] font-bold">{{ $notif->title }}</h3>
                        @if(!$notif->is_read)
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-[#C75B39] text-white">Baru</span>
                        @endif
                    </div>
                    <p class="text-[#8B3A3A] text-sm font-medium">{{ $notif->message }}</p>
                    <p class="text-[#8B3A3A]/70 text-xs font-medium mt-2">{{ $notif->created_at->format('d M Y, H:i') }}</p>
                </div>
                
                @if(!$notif->is_read)
                <form action="{{ route('peminjam.notifikasi.baca', $notif->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs font-bold text-[#C75B39] hover:text-[#8B3A3A] hover:underline whitespace-nowrap">
                        Tandai dibaca
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white border-2 border-[#C75B39]/20 rounded-xl p-8 sm:p-12 text-center">
            <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-[#FFF5E8] border-2 border-[#C75B39]/30 flex items-center justify-center">
                <svg class="w-8 h-8 text-[#C75B39]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <p class="text-[#4A1C1C] text-lg font-bold">Belum ada notifikasi</p>
            <p class="text-[#8B3A3A] text-sm font-medium mt-1">Notifikasi akan muncul di sini saat ada pembaruan</p>
        </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
    @endif
</x-layout-peminjam>