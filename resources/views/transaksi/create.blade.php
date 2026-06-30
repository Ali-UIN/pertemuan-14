<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-plus-circle"></i> Form Peminjaman Buku
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('transaksi.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="anggota_id" class="block text-sm font-medium text-gray-700">Pilih Anggota <span class="text-red-500">*</span></label>
                        <select name="anggota_id" id="anggota_id"
                                class="mt-1 block w-full rounded-md shadow-sm text-sm @error('anggota_id') border-red-500 @else border-gray-300 @enderror">
                            <option value="">-- Pilih Anggota --</option>
                            @foreach($anggotas as $anggota)
                                <option value="{{ $anggota->id }}" @selected(old('anggota_id') == $anggota->id)>
                                    {{ $anggota->kode_anggota }} - {{ $anggota->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('anggota_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        <small class="text-gray-500">Hanya anggota dengan status Aktif yang dapat meminjam</small>
                    </div>

                    <div>
                        <label for="buku_id" class="block text-sm font-medium text-gray-700">Pilih Buku <span class="text-red-500">*</span></label>
                        <select name="buku_id" id="buku_id"
                                class="mt-1 block w-full rounded-md shadow-sm text-sm @error('buku_id') border-red-500 @else border-gray-300 @enderror">
                            <option value="">-- Pilih Buku --</option>
                            @foreach($bukus as $buku)
                                <option value="{{ $buku->id }}" @selected(old('buku_id') == $buku->id)>
                                    {{ $buku->judul }} - (Stok: {{ $buku->stok }})
                                </option>
                            @endforeach
                        </select>
                        @error('buku_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        <small class="text-gray-500">Hanya buku dengan stok tersedia yang dapat dipinjam</small>
                    </div>

                    <div>
                        <label for="tanggal_pinjam" class="block text-sm font-medium text-gray-700">Tanggal Pinjam <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}"
                               class="mt-1 block w-full rounded-md shadow-sm text-sm @error('tanggal_pinjam') border-red-500 @else border-gray-300 @enderror">
                        @error('tanggal_pinjam')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        <small class="text-gray-500">Tanggal kembali otomatis 7 hari dari tanggal pinjam</small>
                    </div>

                    <div>
                        <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" rows="3" placeholder="Keterangan tambahan (opsional)"
                                  class="mt-1 block w-full rounded-md shadow-sm text-sm @error('keterangan') border-red-500 @else border-gray-300 @enderror">{{ old('keterangan') }}</textarea>
                        @error('keterangan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="px-4 py-3 rounded-lg bg-blue-50 text-blue-800 text-sm">
                        <i class="bi bi-info-circle"></i> <strong>Informasi Peminjaman:</strong>
                        <ul class="mt-2 ml-5 list-disc space-y-0.5">
                            <li>Durasi peminjaman: <strong>7 hari</strong></li>
                            <li>Denda keterlambatan: <strong>Rp 5.000/hari</strong></li>
                            <li>Stok buku akan berkurang otomatis setelah peminjaman</li>
                        </ul>
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <a href="{{ route('transaksi.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 text-sm rounded-md hover:bg-gray-50">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                            <i class="bi bi-save"></i> Proses Peminjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
