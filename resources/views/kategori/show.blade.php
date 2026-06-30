<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-tag"></i> Detail Kategori
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-500 mb-4">
                <a href="{{ route('kategori.index') }}" class="hover:text-gray-700">Kategori</a>
                <span class="mx-1">/</span>
                <span class="text-gray-700">{{ $kategori->nama_kategori }}</span>
            </nav>

            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6 flex items-start justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">
                        @if($kategori->icon)<i class="bi bi-{{ $kategori->icon }} text-indigo-500"></i>@endif
                        {{ $kategori->nama_kategori }}
                    </h3>
                    <p class="text-gray-600 mt-1">{{ $kategori->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                    <p class="text-sm text-gray-700 mt-2"><strong>Jumlah buku:</strong> {{ $kategori->bukus_count }}</p>
                </div>
                <a href="{{ route('kategori.edit', $kategori->id) }}"
                   class="px-4 py-2 bg-amber-500 text-white text-sm rounded-md hover:bg-amber-600">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>

            <h5 class="font-semibold text-gray-800 mb-3">Daftar Buku</h5>
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengarang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($buku_list as $index => $buku)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <a href="{{ route('buku.show', $buku->id) }}" class="text-indigo-600 hover:underline">{{ $buku->judul }}</a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $buku->pengarang }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $buku->tahun_terbit }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $buku->stok }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada buku di kategori ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
