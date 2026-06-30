<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-person"></i> Detail Anggota
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-500 mb-4">
                <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
                <span class="mx-1">/</span>
                <a href="{{ route('anggota.index') }}" class="hover:text-gray-700">Anggota</a>
                <span class="mx-1">/</span>
                <span class="text-gray-700">{{ $anggota->nama }}</span>
            </nav>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 bg-white shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-green-600 text-white">
                        <h4 class="font-semibold"><i class="bi bi-person"></i> Detail Anggota</h4>
                    </div>
                    <div class="p-6">
                        <div class="text-center mb-6">
                            <i class="bi bi-person-circle {{ $anggota->jenis_kelamin == 'Laki-laki' ? 'text-indigo-500' : 'text-pink-500' }}" style="font-size: 5rem;"></i>
                            <h3 class="mt-2 text-xl font-semibold text-gray-900">{{ $anggota->nama }}</h3>
                            @if ($anggota->status == 'Aktif')
                                <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800"><i class="bi bi-check-circle"></i>&nbsp;Anggota Aktif</span>
                            @else
                                <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-gray-100 text-gray-700"><i class="bi bi-x-circle"></i>&nbsp;Nonaktif</span>
                            @endif
                        </div>

                        <dl class="divide-y divide-gray-100">
                            @foreach ([
                                'Kode Anggota' => $anggota->kode_anggota,
                                'Email' => $anggota->email,
                                'Telepon' => $anggota->telepon,
                                'Alamat' => $anggota->alamat,
                                'Tanggal Lahir' => $anggota->tanggal_lahir->format('d F Y') . ' (' . $anggota->umur . ' tahun)',
                                'Jenis Kelamin' => $anggota->jenis_kelamin,
                                'Pekerjaan' => $anggota->pekerjaan ?? '-',
                                'Tanggal Daftar' => $anggota->tanggal_daftar->format('d F Y') . ' (' . $anggota->lama_anggota . ' hari)',
                            ] as $label => $value)
                                <div class="py-2 flex">
                                    <dt class="w-48 text-sm font-medium text-gray-500">{{ $label }}</dt>
                                    <dd class="text-sm text-gray-900">{{ $value }}</dd>
                                </div>
                            @endforeach
                        </dl>

                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between text-xs text-gray-400">
                            <span><i class="bi bi-clock"></i> Ditambahkan: {{ $anggota->created_at->format('d M Y H:i') }}</span>
                            <span><i class="bi bi-clock-history"></i> Update: {{ $anggota->updated_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden h-fit">
                    <div class="px-6 py-4 bg-gray-600 text-white">
                        <h6 class="font-semibold"><i class="bi bi-gear"></i> Aksi</h6>
                    </div>
                    <div class="p-6 space-y-2">
                        <a href="{{ route('anggota.edit', $anggota->id) }}" class="block text-center px-4 py-2 bg-amber-500 text-white text-sm rounded-md hover:bg-amber-600">
                            <i class="bi bi-pencil"></i> Edit Anggota
                        </a>
                        <a href="{{ route('anggota.index') }}" class="block text-center px-4 py-2 border border-green-600 text-green-700 text-sm rounded-md hover:bg-green-50">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <form action="{{ route('anggota.destroy', $anggota->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white text-sm rounded-md hover:bg-red-600">
                                <i class="bi bi-trash"></i> Hapus Anggota
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Statistik Peminjaman --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                <div class="bg-white shadow-sm sm:rounded-lg p-4 text-center border-t-4 border-blue-500">
                    <p class="text-sm text-gray-500">Total Pinjam</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $statistik['total_pinjam'] }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-4 text-center border-t-4 border-amber-500">
                    <p class="text-sm text-gray-500">Sedang Dipinjam</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $statistik['sedang_pinjam'] }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-4 text-center border-t-4 border-green-500">
                    <p class="text-sm text-gray-500">Dikembalikan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $statistik['dikembalikan'] }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-4 text-center border-t-4 border-red-500">
                    <p class="text-sm text-gray-500">Total Denda</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($statistik['total_denda'], 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Riwayat Peminjaman --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden mt-6">
                <div class="px-6 py-4 bg-green-600 text-white">
                    <h4 class="font-semibold"><i class="bi bi-clock-history"></i> Riwayat Peminjaman</h4>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Kembali</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Denda</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($riwayat as $trx)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $trx->kode_transaksi }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $trx->buku->judul ?? '-' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $trx->tanggal_pinjam->format('d M Y') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $trx->tanggal_kembali->format('d M Y') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $trx->status == 'Dipinjam' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $trx->status }}
                                        </span>
                                        @if($trx->status == 'Dipinjam' && $trx->terlambat > 0)
                                            <span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Terlambat {{ $trx->terlambat }} hari
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm {{ $trx->denda > 0 ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                                        {{ $trx->denda > 0 ? 'Rp ' . number_format($trx->denda, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                                        <a href="{{ route('transaksi.show', $trx->id) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-500">Anggota ini belum pernah meminjam buku.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
