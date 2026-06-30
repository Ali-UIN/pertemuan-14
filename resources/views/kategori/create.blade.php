<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-plus-circle"></i> Tambah Kategori
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('kategori.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="nama_kategori" class="block text-sm font-medium text-gray-700">Nama Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori') }}"
                               class="mt-1 block w-full rounded-md shadow-sm text-sm @error('nama_kategori') border-red-500 @else border-gray-300 @enderror">
                        @error('nama_kategori')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3"
                                  class="mt-1 block w-full rounded-md shadow-sm text-sm border-gray-300">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="icon" class="block text-sm font-medium text-gray-700">Icon (Bootstrap Icon)</label>
                            <input type="text" name="icon" id="icon" value="{{ old('icon') }}" placeholder="cth: code-slash"
                                   class="mt-1 block w-full rounded-md shadow-sm text-sm border-gray-300">
                        </div>
                        <div>
                            <label for="warna" class="block text-sm font-medium text-gray-700">Warna</label>
                            <input type="text" name="warna" id="warna" value="{{ old('warna') }}" placeholder="cth: primary"
                                   class="mt-1 block w-full rounded-md shadow-sm text-sm border-gray-300">
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('kategori.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 text-sm rounded-md hover:bg-gray-50">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
