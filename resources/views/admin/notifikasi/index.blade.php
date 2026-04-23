{{-- resources/views/admin/notifikasi/index.blade.php --}}
<x-layout-admin>
    <x-slot name="title">Notifikasi</x-slot>
    
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold text-[#2C1810] brand">Notifikasi</h1>
            <p class="text-[#9a8a80] text-xs sm:text-sm mt-1">Informasi dan pemberitahuan sistem</p>
        </div>
        
        @php
            $unreadCount = \App\Models\UserNotification::where('user_id', auth()->id())
                ->where('is_read', false)
                ->count();
        @endphp
        @if($unreadCount > 0)
        <form action="{{ route('admin.notifikasi.baca-semua') }}" method="POST">
            @csrf
            <button type="submit" class="text-sm font-medium text-[#7B1518] hover:text-[#5A1013] hover:underline transition">
                ✓ Tandai semua sudah dibaca ({{ $unreadCount }})
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

    {{-- Filter Type --}}
    <div class="mb-4 flex gap-2 overflow-x-auto pb-2">
        @php
            $types = [
                '' => 'Semua',
                'booking_created' => '📚 Peminjaman',
                'booking_returned' => '📦 Pengembalian',
                'user_created' => '👤 User Baru',
                'book_created' => '📖 Buku',
                'category_created' => '🏷️ Kategori',
            ];
            $currentType = request('type', '');
        @endphp
        @foreach($types as $key => $label)
        <a href="{{ route('admin.notifikasi.index', $key ? ['type' => $key] : []) }}" 
            class="px-3 py-1.5 text-xs font-medium rounded-full whitespace-nowrap transition
                {{ $currentType == $key 
                    ? 'bg-[#7B1518] text-white shadow-sm' 
                    : 'bg-white text-[#6b5a54] border border-[#7B1518]/20 hover:bg-[#7B1518]/5' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    <div class="space-y-3">
        @forelse($notifications as $notif)
        <div class="bg-white rounded-xl border {{ $notif->is_read ? 'border-[#7B1518]/10' : 'border-l-4 border-l-[#7B1518] border-[#7B1518]/10' }} p-4 shadow-sm hover:shadow-md transition">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-lg">
                            @php
                                $icons = [
                                    'booking_created' => '📚',
                                    'booking_approved' => '✅',
                                    'booking_rejected' => '❌',
                                    'booking_returned' => '📦',
                                    'booking_cancelled' => '🚫',
                                    'user_created' => '👤',
                                    'user_blocked' => '🚫',
                                    'user_activated' => '✅',
                                    'user_deleted' => '🗑️',
                                    'book_created' => '📖',
                                    'book_updated' => '✏️',
                                    'book_deleted' => '🗑️',
                                    'penalty_cleared' => '🎊',
                                    'category_created' => '🏷️',
                                    'category_updated' => '✏️',
                                    'category_deleted' => '🗑️',
                                ];
                            @endphp
                            {{ $icons[$notif->type] ?? '📋' }}
                        </span>
                        <h3 class="text-[#2C1810] font-semibold text-sm sm:text-base">{{ $notif->title }}</h3>
                        @if(!$notif->is_read)
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-[#7B1518] text-white">Baru</span>
                        @endif
                    </div>
                    <p class="text-[#6b5a54] text-sm">{{ $notif->message }}</p>
                    <p class="text-[#9a8a80] text-xs mt-2 flex items-center gap-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $notif->created_at->diffForHumans() }} • {{ $notif->created_at->format('d M Y, H:i') }}
                    </p>
                </div>
                
                <div class="flex items-center gap-2">
                    @php
                        $showLink = true;
                        
                        // Cek buku (termasuk soft deleted)
                        if (in_array($notif->type, ['book_created', 'book_updated']) && $notif->book_id) {
                            $bookExists = \App\Models\Book::withTrashed()->where('id', $notif->book_id)->exists();
                            $showLink = $bookExists;
                        }
                        
                        // Cek peminjaman
                        if (in_array($notif->type, ['booking_created', 'booking_approved', 'booking_rejected', 'booking_returned']) && $notif->booking_id) {
                            $bookingExists = \App\Models\Booking::where('id', $notif->booking_id)->exists();
                            $showLink = $bookingExists;
                        }
                        
                        // Cek user
                        if (in_array($notif->type, ['user_created', 'user_blocked', 'user_activated']) && isset($notif->data['user_id'])) {
                            $userExists = \App\Models\User::where('id', $notif->data['user_id'])->exists();
                            $showLink = $userExists;
                        }
                        
                        // Jangan tampilkan link untuk item yang dihapus
                        if (in_array($notif->type, ['book_deleted', 'user_deleted', 'category_deleted'])) {
                            $showLink = false;
                        }
                    @endphp
                    
                    @if($notif->url && $showLink)
                    <a href="{{ $notif->url }}" 
                        class="text-xs font-medium text-[#7B1518] hover:underline whitespace-nowrap px-3 py-1.5 bg-[#7B1518]/5 rounded-lg hover:bg-[#7B1518]/10 transition">
                        Lihat Detail →
                    </a>
                    @endif
                    
                    @if(!$notif->is_read)
                    <form action="{{ route('admin.notifikasi.baca', $notif->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs font-medium text-[#9a8a80] hover:text-[#7B1518] hover:underline whitespace-nowrap px-3 py-1.5">
                            Tandai dibaca
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl border border-[#7B1518]/10 p-8 sm:p-12 text-center">
            <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-[#7B1518]/5 flex items-center justify-center">
                <svg class="w-8 h-8 text-[#7B1518]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <p class="text-[#6b5a54] text-lg font-medium">Belum ada notifikasi</p>
            <p class="text-[#9a8a80] text-sm mt-1">Notifikasi akan muncul di sini saat ada pembaruan sistem</p>
        </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
    @endif

    @push('scripts')
    <script>
        let notificationTimer;
        
        function updateNotificationCount() {
            fetch('{{ route("admin.notifikasi.unread-count") }}')
                .then(res => res.json())
                .then(data => {
                    const badge = document.querySelector('[data-notif-badge]');
                    if (badge) {
                        if (data.count > 0) {
                            badge.textContent = data.count;
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    }
                })
                .catch(err => console.log('Polling error:', err));
        }
        
        notificationTimer = setInterval(updateNotificationCount, 30000);
        
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                clearInterval(notificationTimer);
            } else {
                notificationTimer = setInterval(updateNotificationCount, 30000);
                updateNotificationCount();
            }
        });
    </script>
    @endpush
</x-layout-admin>