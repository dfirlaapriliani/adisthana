<x-layout-peminjam>
    <x-slot name="title">Notifikasi</x-slot>
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-white" style="font-family: 'Cormorant Garamond', serif;">Notifikasi</h1>
            <p class="text-[#5a5a65] text-sm mt-1">Informasi dan pemberitahuan untuk Anda</p>
        </div>
        
        @php
            $unreadCount = \App\Models\UserNotification::where('user_id', auth()->id())
                ->where('is_read', false)
                ->count();
        @endphp
        @if($unreadCount > 0)
        <form action="{{ route('peminjam.notifikasi.baca-semua') }}" method="POST">
            @csrf
            <button type="submit" class="text-sm text-[#d4af6a] hover:underline">
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
        <div class="bg-[#111114] border border-white/[0.08] rounded-xl p-4 {{ $notif->is_read ? '' : 'border-l-4 border-l-[#d4af6a]' }}">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <h3 class="text-white font-medium">{{ $notif->title }}</h3>
                        @if(!$notif->is_read)
                            <span class="px-2 py-0.5 text-[10px] rounded-full bg-[#d4af6a]/20 text-[#d4af6a]">Baru</span>
                        @endif
                    </div>
                    <p class="text-[#8a8a95] text-sm">{{ $notif->message }}</p>
                    <p class="text-[#5a5a65] text-xs mt-2">{{ $notif->created_at->format('d M Y, H:i') }}</p>
                </div>
                
                @if(!$notif->is_read)
                <form action="{{ route('peminjam.notifikasi.baca', $notif->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs text-[#d4af6a] hover:underline whitespace-nowrap">
                        Tandai dibaca
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-[#111114] border border-white/[0.08] rounded-xl p-12 text-center">
            <svg class="w-16 h-16 text-[#3d3d45] mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <p class="text-[#8a8a95] text-lg">Belum ada notifikasi</p>
            <p class="text-[#5a5a65] text-sm mt-1">Notifikasi akan muncul di sini saat ada pembaruan</p>
        </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
    @endif
</x-layout-peminjam>