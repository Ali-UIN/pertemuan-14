<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-tags"></i> Daftar Kategori Buku
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                <form action="{{ route('kategori.index') }}" method="GET" class="flex gap-2">
                    <input type="search" name="q" value="{{ request('q') }}"
                        placeholder="Cari kategori..."
                        class="px-3 py-2 text-sm border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500" />
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-white text-sm rounded-md hover:bg-gray-700">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                <a href="{{ route('kategori.create') }}"
                   class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">
                    <i class="bi bi-plus-circle"></i>&nbsp;Tambah Kategori
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($kategori_list as $kategori)
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col">
                        <div class="flex items-center gap-2">
                            @if($kategori->icon)
                                <i class="bi bi-{{ $kategori->icon }} text-indigo-500 text-xl"></i>
                            @endif
                            <h5 class="text-lg font-semibold text-gray-900">{{ $kategori->nama_kategori }}</h5>
                        </div>
                        <p class="text-gray-600 mt-1 flex-grow">{{ $kategori->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                        <p class="text-sm text-gray-700 mt-3"><strong>Jumlah buku:</strong> {{ $kategori->bukus_count }}</p>
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('kategori.show', $kategori->id) }}"
                               class="flex-1 text-center px-3 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">Detail</a>
                            <a href="{{ route('kategori.edit', $kategori->id) }}"
                               class="flex-1 text-center px-3 py-2 bg-amber-500 text-white text-sm rounded-md hover:bg-amber-600">Edit</a>
                            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 bg-red-500 text-white text-sm rounded-md hover:bg-red-600">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white shadow-sm sm:rounded-lg p-6 text-center text-gray-500">
                        Belum ada kategori. <a href="{{ route('kategori.create') }}" class="text-indigo-600">Tambah sekarang</a>.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
