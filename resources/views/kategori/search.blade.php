<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-search"></i> Hasil Pencarian Kategori
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <p class="mb-4 text-gray-600">Keyword: <mark class="bg-yellow-200 px-1 rounded">{{ $keyword }}</mark></p>

            @if (count($hasil) === 0)
                <div class="px-4 py-3 rounded-lg bg-yellow-100 text-yellow-800">Tidak ada kategori yang cocok.</div>
            @else
                <div class="space-y-3">
                    @foreach ($hasil as $kategori)
                        @php
                            $nama = str_ireplace($keyword, '<mark class="bg-yellow-200">' . $keyword . '</mark>', $kategori['nama']);
                            $deskripsi = str_ireplace($keyword, '<mark class="bg-yellow-200">' . $keyword . '</mark>', $kategori['deskripsi']);
                        @endphp
                        <div class="bg-white shadow-sm sm:rounded-lg p-5">
                            <h5 class="text-lg font-semibold text-gray-900">{!! $nama !!}</h5>
                            <p class="text-gray-600 mt-1">{!! $deskripsi !!}</p>
                            <small class="text-gray-500">Jumlah buku: {{ $kategori['jumlah_buku'] }}</small>
                            <div class="mt-3">
                                <a href="{{ route('kategori.show', $kategori['id']) }}"
                                   class="inline-block px-3 py-1.5 border border-indigo-600 text-indigo-600 text-sm rounded-md hover:bg-indigo-50">Detail</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
