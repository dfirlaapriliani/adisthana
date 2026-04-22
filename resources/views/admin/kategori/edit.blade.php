<x-layout-admin>
    <x-slot name="title">Edit Kategori</x-slot>
    
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-[#2C1810]" style="font-family: 'Cormorant Garamond', serif;">Edit Kategori</h1>
        <p class="text-[#9a8a80] text-sm mt-1">Perbarui informasi kategori</p>
    </div>

    <div class="bg-white rounded-2xl border border-[#7B1518]/10 shadow-sm p-6 max-w-2xl">
        <form action="{{ route('admin.kategori.update', $kategori) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                    Nama Kategori <span class="text-[#7B1518]">*</span>
                </label>
                <input type="text" name="nama" value="{{ old('nama', $kategori->nama) }}" required
                    class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition @error('nama') border-red-300 @enderror">
                <p class="text-xs text-[#9a8a80] mt-1">Slug: {{ $kategori->slug }}</p>
                @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#7B1518]/10">
                <a href="{{ route('admin.kategori.index') }}" 
                    class="px-4 py-2.5 text-sm text-[#6b5a54] hover:text-[#2C1810] transition">
                    Batal
                </a>
                <button type="submit" 
                    class="px-6 py-2.5 bg-[#7B1518] text-white rounded-xl text-sm font-medium hover:bg-[#5a0f12] transition shadow-sm">
                    Perbarui Kategori
                </button>
            </div>
        </form>
    </div>
</x-layout-admin>