<x-layout-admin>
    <x-slot name="title">Notifikasi</x-slot>
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[#2C1810]" style="font-family: 'Cormorant Garamond', serif;">Notifikasi</h1>
            <p class="text-[#9a8a80] text-sm mt-1">Informasi dan pemberitahuan sistem</p>
        </div>
        
        @php
            $unreadCount = \App\Models\UserNotification::where('user_id', auth()->id())
                ->where('is_read', false)
                ->count();
        @endphp
        @if($unreadCount > 0)
        <form action="{{ route('admin.notifikasi.baca-semua') }}" method="POST">
            @csrf
            <button type="submit" class="text-sm text-[#7B1518] hover:underline">
                Tandai semua sudah dibaca
            </button>
        </form>
        @endif
    </div>

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center justify-between">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm text-green-800">{{ session('success') }}</p>
        </div>
        <button @click="show = false" class="text-green-600 hover:text-green-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    @endif

    <div class="space-y-3">
        @forelse($notifications as $notif)
        <div class="bg-white rounded-xl border {{ $notif->is_read ? 'border-[#7B1518]/10' : 'border-l-4 border-l-[#7B1518] border-[#7B1518]/10' }} p-4 shadow-sm">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <h3 class="text-[#2C1810] font-medium">{{ $notif->title }}</h3>
                        @if(!$notif->is_read)
                            <span class="px-2 py-0.5 text-[10px] rounded-full bg-[#7B1518]/10 text-[#7B1518]">Baru</span>
                        @endif
                    </div>
                    <p class="text-[#6b5a54] text-sm">{{ $notif->message }}</p>
                    <p class="text-[#9a8a80] text-xs mt-2">{{ $notif->created_at->format('d M Y, H:i') }}</p>
                </div>
                
                @if(!$notif->is_read)
                <form action="{{ route('admin.notifikasi.baca', $notif->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs text-[#7B1518] hover:underline whitespace-nowrap">
                        Tandai dibaca
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl border border-[#7B1518]/10 p-12 text-center">
            <svg class="w-16 h-16 text-[#c4a898] mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <p class="text-[#9a8a80] text-lg">Belum ada notifikasi</p>
            <p class="text-[#c4a898] text-sm mt-1">Notifikasi akan muncul di sini saat ada pembaruan</p>
        </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
    @endif
</x-layout-admin>