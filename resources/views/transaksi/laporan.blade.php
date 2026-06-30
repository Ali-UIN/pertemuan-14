<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-file-earmark-bar-graph"></i> Laporan Transaksi
            </h2>
            <a href="{{ route('transaksi.laporan.pdf', request()->query()) }}"
               class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700">
                <i class="bi bi-file-earmark-pdf mr-1"></i> Export PDF
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- FORM FILTER --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                                <form method="GET" action="{{ route('transaksi.laporan') }}">
                    {{-- Baris input: 4 kolom --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Dari Tanggal</label>
                            <input type="date" name="dari" value="{{ request('dari') }}"
                                   class="w-full rounded-md border-gray-300 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Sampai Tanggal</label>
                            <input type="date" name="sampai" value="{{ request('sampai') }}"
                                   class="w-full rounded-md border-gray-300 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Status</label>
                            <select name="status" class="w-full rounded-md border-gray-300 text-sm">
                                <option value="">Semua</option>
                                <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Anggota</label>
                            <select name="anggota_id" class="w-full rounded-md border-gray-300 text-sm">
                                <option value="">Semua</option>
                                @foreach($anggotas as $anggota)
                                    <option value="{{ $anggota->id }}" {{ request('anggota_id') == $anggota->id ? 'selected' : '' }}>
                                        {{ $anggota->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Baris tombol: di luar grid, rata kiri --}}
                    <div class="flex gap-2 mt-4 justify-end">
                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <a href="{{ route('transaksi.laporan') }}"
                           class="px-4 py-2 border border-gray-300 text-gray-600 text-sm rounded-md hover:bg-gray-50">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- RINGKASAN --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                    <p class="text-sm font-medium text-gray-600">Total Transaksi</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $transaksis->count() }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <p class="text-sm font-medium text-gray-600">Total Denda</p>
                    <p class="text-2xl font-semibold text-red-600">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- TABEL --}}
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
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Denda</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($transaksis as $transaksi)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-sm"><code class="text-indigo-600">{{ $transaksi->kode_transaksi }}</code></td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $transaksi->anggota->nama }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $transaksi->buku->judul }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $transaksi->tanggal_kembali->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $transaksi->status }}</td>
                                    <td class="px-6 py-4 text-right text-sm {{ $transaksi->denda > 0 ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                                        Rp {{ number_format($transaksi->denda, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data sesuai filter</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
