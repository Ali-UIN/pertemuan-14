<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-plus-circle"></i> Tambah Buku Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('buku.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <div class="md:col-span-4">
                            <label for="kode_buku" class="block text-sm font-medium text-gray-700">Kode Buku <span class="text-red-500">*</span></label>
                            <input type="text" name="kode_buku" id="kode_buku" value="{{ old('kode_buku') }}" placeholder="Contoh: BK-001"
                                   class="mt-1 block w-full rounded-md shadow-sm text-sm @error('kode_buku') border-red-500 @else border-gray-300 @enderror">
                            @error('kode_buku')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="md:col-span-8">
                            <label for="judul" class="block text-sm font-medium text-gray-700">Judul Buku <span class="text-red-500">*</span></label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" placeholder="Masukkan judul buku"
                                   class="mt-1 block w-full rounded-md shadow-sm text-sm @error('judul') border-red-500 @else border-gray-300 @enderror">
                            @error('judul')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori <span class="text-red-500">*</span></label>
                            <select name="kategori_id" id="kategori_id"
                                    class="mt-1 block w-full rounded-md shadow-sm text-sm @error('kategori_id') border-red-500 @else border-gray-300 @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kat)
                                    <option value="{{ $kat->id }}" @selected(old('kategori_id') == $kat->id)>{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="pengarang" class="block text-sm font-medium text-gray-700">Pengarang <span class="text-red-500">*</span></label>
                            <input type="text" name="pengarang" id="pengarang" value="{{ old('pengarang') }}" placeholder="Nama pengarang"
                                   class="mt-1 block w-full rounded-md shadow-sm text-sm @error('pengarang') border-red-500 @else border-gray-300 @enderror">
                            @error('pengarang')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="penerbit" class="block text-sm font-medium text-gray-700">Penerbit <span class="text-red-500">*</span></label>
                            <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit') }}" placeholder="Nama penerbit"
                                   class="mt-1 block w-full rounded-md shadow-sm text-sm @error('penerbit') border-red-500 @else border-gray-300 @enderror">
                            @error('penerbit')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        <div>
                            <label for="tahun_terbit" class="block text-sm font-medium text-gray-700">Tahun <span class="text-red-500">*</span></label>
                            <input type="number" name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit', date('Y')) }}" min="1900" max="{{ date('Y') }}"
                                   class="mt-1 block w-full rounded-md shadow-sm text-sm @error('tahun_terbit') border-red-500 @else border-gray-300 @enderror">
                            @error('tahun_terbit')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN</label>
                            <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}" placeholder="978-xxx"
                                   class="mt-1 block w-full rounded-md shadow-sm text-sm @error('isbn') border-red-500 @else border-gray-300 @enderror">
                            @error('isbn')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="bahasa" class="block text-sm font-medium text-gray-700">Bahasa <span class="text-red-500">*</span></label>
                            <select name="bahasa" id="bahasa"
                                    class="mt-1 block w-full rounded-md shadow-sm text-sm @error('bahasa') border-red-500 @else border-gray-300 @enderror">
                                <option value="Indonesia" @selected(old('bahasa', 'Indonesia') == 'Indonesia')>Indonesia</option>
                                <option value="Inggris" @selected(old('bahasa') == 'Inggris')>Inggris</option>
                            </select>
                            @error('bahasa')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="harga" class="block text-sm font-medium text-gray-700">Harga <span class="text-red-500">*</span></label>
                            <input type="number" name="harga" id="harga" value="{{ old('harga', 0) }}" min="0" step="1000"
                                   class="mt-1 block w-full rounded-md shadow-sm text-sm @error('harga') border-red-500 @else border-gray-300 @enderror">
                            @error('harga')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="stok" class="block text-sm font-medium text-gray-700">Stok <span class="text-red-500">*</span></label>
                            <input type="number" name="stok" id="stok" value="{{ old('stok', 0) }}" min="0"
                                   class="mt-1 block w-full rounded-md shadow-sm text-sm @error('stok') border-red-500 @else border-gray-300 @enderror">
                            @error('stok')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" placeholder="Deskripsi singkat (opsional)"
                                  class="mt-1 block w-full rounded-md shadow-sm text-sm @error('deskripsi') border-red-500 @else border-gray-300 @enderror">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <a href="{{ route('buku.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 text-sm rounded-md hover:bg-gray-50">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                            <i class="bi bi-save"></i> Simpan Buku
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
