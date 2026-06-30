<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-people"></i> Daftar Anggota
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('anggota.export') }}"
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">
                    <i class="bi bi-file-excel mr-1"></i> Export Excel
                </a>
                <a href="{{ route('anggota.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                    <i class="bi bi-plus-circle mr-1"></i> Tambah Anggota
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Search & Filter --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('anggota.search') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-2">
                    <input type="text" name="keyword" placeholder="Cari nama/email/telepon" value="{{ request('keyword') }}"
                           class="md:col-span-3 border-gray-300 rounded-md shadow-sm text-sm">
                    <select name="jenis_kelamin" class="md:col-span-2 border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">Semua Jenis Kelamin</option>
                        <option value="Laki-laki" @selected(request('jenis_kelamin') == 'Laki-laki')>Laki-laki</option>
                        <option value="Perempuan" @selected(request('jenis_kelamin') == 'Perempuan')>Perempuan</option>
                    </select>
                    <select name="status" class="md:col-span-2 border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">Semua Status</option>
                        <option value="Aktif" @selected(request('status') == 'Aktif')>Aktif</option>
                        <option value="Nonaktif" @selected(request('status') == 'Nonaktif')>Nonaktif</option>
                    </select>
                    <select name="pekerjaan" class="md:col-span-2 border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">Semua Pekerjaan</option>
                        <option value="Mahasiswa" @selected(request('pekerjaan') == 'Mahasiswa')>Mahasiswa</option>
                        <option value="Pegawai" @selected(request('pekerjaan') == 'Pegawai')>Pegawai</option>
                        <option value="Wiraswasta" @selected(request('pekerjaan') == 'Wiraswasta')>Wiraswasta</option>
                    </select>
                    <div class="md:col-span-3 flex gap-2">
                        <button type="submit" class="flex-1 px-3 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700"><i class="bi bi-search"></i> Cari</button>
                        <a href="{{ route('anggota.index') }}" class="flex-1 text-center px-3 py-2 border border-gray-300 text-gray-600 text-sm rounded-md hover:bg-gray-50"><i class="bi bi-x"></i> Reset</a>
                    </div>
                </form>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex items-center justify-between border-l-4 border-green-500">
                    <div><p class="text-sm font-medium text-gray-600">Total Anggota</p><p class="text-2xl font-semibold text-gray-900">{{ $totalAnggota }}</p></div>
                    <i class="bi bi-people-fill text-green-500 text-4xl"></i>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex items-center justify-between border-l-4 border-indigo-500">
                    <div><p class="text-sm font-medium text-gray-600">Anggota Aktif</p><p class="text-2xl font-semibold text-gray-900">{{ $anggotaAktif }}</p></div>
                    <i class="bi bi-person-check-fill text-indigo-500 text-4xl"></i>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex items-center justify-between border-l-4 border-gray-400">
                    <div><p class="text-sm font-medium text-gray-600">Anggota Nonaktif</p><p class="text-2xl font-semibold text-gray-900">{{ $anggotaNonaktif }}</p></div>
                    <i class="bi bi-person-x-fill text-gray-400 text-4xl"></i>
                </div>
            </div>

            {{-- Tabel Anggota --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Telepon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Kelamin</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($anggotas as $anggota)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"><code class="text-indigo-600">{{ $anggota->kode_anggota }}</code></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $anggota->nama }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><i class="bi bi-envelope"></i> {{ $anggota->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><i class="bi bi-telephone"></i> {{ $anggota->telepon }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if ($anggota->jenis_kelamin == 'Laki-laki')
                                            <i class="bi bi-gender-male text-indigo-500"></i>
                                        @else
                                            <i class="bi bi-gender-female text-pink-500"></i>
                                        @endif
                                        {{ $anggota->jenis_kelamin }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($anggota->status == 'Aktif')
                                            <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800"><i class="bi bi-check-circle"></i>&nbsp;Aktif</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-gray-100 text-gray-700"><i class="bi bi-x-circle"></i>&nbsp;Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-1">
                                        <a href="{{ route('anggota.show', $anggota->id) }}" title="Detail" class="inline-block px-2 py-1 rounded bg-sky-500 text-white hover:bg-sky-600"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('anggota.edit', $anggota->id) }}" title="Edit" class="inline-block px-2 py-1 rounded bg-amber-400 text-amber-900 hover:bg-amber-500"><i class="bi bi-pencil"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500"><i class="bi bi-inbox"></i> Tidak ada data anggota</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
