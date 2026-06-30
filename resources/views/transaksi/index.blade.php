<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-arrow-left-right"></i> Daftar Transaksi Peminjaman
            </h2>
            <div class="flex items-center gap-2">
                <a href="{{ route('transaksi.laporan') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">
                    <i class="bi bi-file-earmark-bar-graph mr-1"></i> Laporan
                </a>
                <a href="{{ route('transaksi.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                    <i class="bi bi-plus-circle mr-1"></i> Pinjam Buku
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                    <p class="text-sm font-medium text-gray-600">Total Transaksi</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $transaksis->count() }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6 border-l-4 border-amber-500">
                    <p class="text-sm font-medium text-gray-600">Sedang Dipinjam</p>
                    <p class="text-2xl font-semibold text-amber-600">{{ $transaksis->where('status', 'Dipinjam')->count() }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <p class="text-sm font-medium text-gray-600">Sudah Dikembalikan</p>
                    <p class="text-2xl font-semibold text-green-600">{{ $transaksis->where('status', 'Dikembalikan')->count() }}</p>
                </div>
            </div>

            {{-- Tabel --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Anggota</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Buku</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pinjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kembali</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($transaksis as $transaksi)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm"><code class="text-indigo-600">{{ $transaksi->kode_transaksi }}</code></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaksi->anggota->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->buku->judul }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->tanggal_kembali->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($transaksi->status == 'Dipinjam')
                                    <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-amber-100 text-amber-800">Dipinjam</span>
                                    @if($transaksi->terlambat > 0)
                                    <span class="ml-1 px-2 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="bi bi-clock-history"></i>&nbsp;Terlambat {{ $transaksi->terlambat }} hari
                                    </span>
                                    @endif
                                    @else
                                    <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Dikembalikan</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <a href="{{ route('transaksi.show', $transaksi->id) }}" class="inline-block px-2 py-1 rounded bg-sky-500 text-white hover:bg-sky-600"><i class="bi bi-eye"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada transaksi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>