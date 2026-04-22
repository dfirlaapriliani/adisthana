<x-layout-admin>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold" style="color: #7B1518; font-family: 'Cormorant Garamond', serif;">
                Permohonan Akun
            </h1>
            <p class="mt-2 text-sm text-gray-600">
                Daftar permohonan akun yang masuk dari calon peminjam.
            </p>
        </div>
    </div>

    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead style="background-color: #F0EBE3;">
                            <tr>
                                <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Nama</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Kelas</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">No WhatsApp</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Keperluan</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                                <th class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($requests as $req)
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                    {{ $req->nama }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $req->kelas }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $req->no_whatsapp }}
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-500 max-w-xs">
                                    <div class="truncate" title="{{ $req->keperluan }}">
                                        {{ Str::limit($req->keperluan, 50) }}
                                    </div>
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
    <div class="flex items-center justify-end gap-2">
        @if($req->status == 'pending')
            {{-- Setujui --}}
            <form action="{{ route('admin.account-requests.approve', $req->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" 
                        class="p-2 rounded-lg text-green-600 hover:text-green-900 hover:bg-green-50 transition"
                        onclick="return confirm('Setujui permohonan ini?')"
                        title="Setujui & Buat Akun">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </button>
            </form>
            
            {{-- Buat Akun Langsung --}}
            <a href="{{ route('admin.users.create', ['from' => 'permohonan', 'nama' => $req->nama, 'kelas' => $req->kelas, 'phone' => $req->no_whatsapp]) }}" 
               class="p-2 rounded-lg text-blue-600 hover:text-blue-900 hover:bg-blue-50 transition"
               title="Buat Akun Langsung">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
                </svg>
            </a>
            
            {{-- Tolak --}}
            <form action="{{ route('admin.account-requests.reject', $req->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" 
                        class="p-2 rounded-lg text-red-600 hover:text-red-900 hover:bg-red-50 transition"
                        onclick="return confirm('Tolak permohonan ini?')"
                        title="Tolak">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </form>
        @else
            <span class="text-gray-400">-</span>
        @endif
    </div>
</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $req->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    @if($req->status == 'pending')
                                        <form action="{{ route('admin.account-requests.approve', $req->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="text-green-600 hover:text-green-900 mr-3"
                                                    onclick="return confirm('Setujui permohonan ini?')">
                                                Setujui
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.account-requests.reject', $req->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Tolak permohonan ini?')">
                                                Tolak
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-gray-500">
                                    Belum ada permohonan akun masuk.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layout-admin>