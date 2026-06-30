<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-person-plus"></i> Tambah Anggota Baru
        </h2>
    </x-slot>

    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('anggota.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <div class="md:col-span-4">
                            <label for="kode_anggota" class="block text-sm font-medium text-gray-700">Kode Anggota <span class="text-red-500">*</span></label>
                            <input type="text" name="kode_anggota" id="kode_anggota" value="{{ old('kode_anggota', $kodeAnggota) }}" readonly
                                   class="mt-1 block w-full rounded-md shadow-sm text-sm bg-gray-50 @error('kode_anggota') border-red-500 @else border-gray-300 @enderror">
                            @error('kode_anggota')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            <small class="text-gray-500">Format: AGT-XXX</small>
                        </div>
                        <div class="md:col-span-8">
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" placeholder="Nama lengkap anggota"
                                   class="mt-1 block w-full rounded-md shadow-sm text-sm @error('nama') border-red-500 @else border-gray-300 @enderror">
                            @error('nama')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="email@example.com"
                                   class="mt-1 block w-full rounded-md shadow-sm text-sm @error('email') border-red-500 @else border-gray-300 @enderror">
                            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon <span class="text-red-500">*</span></label>
                            <input type="text" name="telepon" id="telepon" value="{{ old('telepon') }}" placeholder="081234567890"
                                   class="mt-1 block w-full rounded-md shadow-sm text-sm @error('telepon') border-red-500 @else border-gray-300 @enderror">
                            @error('telepon')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            <small class="text-gray-500">Format: 08xxxxxxxxxx</small>
                        </div>
                    </div>

                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat" id="alamat" rows="3" placeholder="Alamat lengkap dengan kota dan kode pos"
                                  class="mt-1 block w-full rounded-md shadow-sm text-sm @error('alamat') border-red-500 @else border-gray-300 @enderror">{{ old('alamat') }}</textarea>
                        @error('alamat')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" max="{{ date('Y-m-d') }}"
                                   class="mt-1 block w-full rounded-md shadow-sm text-sm @error('tanggal_lahir') border-red-500 @else border-gray-300 @enderror">
                            @error('tanggal_lahir')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="mt-1 block w-full rounded-md shadow-sm text-sm @error('jenis_kelamin') border-red-500 @else border-gray-300 @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" @selected(old('jenis_kelamin') == 'Laki-laki')>Laki-laki</option>
                                <option value="Perempuan" @selected(old('jenis_kelamin') == 'Perempuan')>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="pekerjaan" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                            <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan') }}" placeholder="Mahasiswa, Pegawai, dll"
                                   class="mt-1 block w-full rounded-md shadow-sm text-sm @error('pekerjaan') border-red-500 @else border-gray-300 @enderror">
                            @error('pekerjaan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tanggal_daftar" class="block text-sm font-medium text-gray-700">Tanggal Pendaftaran <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_daftar" id="tanggal_daftar" value="{{ old('tanggal_daftar', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}"
                                   class="mt-1 block w-full rounded-md shadow-sm text-sm @error('tanggal_daftar') border-red-500 @else border-gray-300 @enderror">
                            @error('tanggal_daftar')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                            <select name="status" id="status"
                                    class="mt-1 block w-full rounded-md shadow-sm text-sm @error('status') border-red-500 @else border-gray-300 @enderror">
                                <option value="Aktif" @selected(old('status', 'Aktif') == 'Aktif')>Aktif</option>
                                <option value="Nonaktif" @selected(old('status') == 'Nonaktif')>Nonaktif</option>
                            </select>
                            @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <a href="{{ route('anggota.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 text-sm rounded-md hover:bg-gray-50">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">
                            <i class="bi bi-save"></i> Simpan Anggota
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script>
        flatpickr("#tanggal_lahir", { dateFormat: "Y-m-d", maxDate: "today", locale: "id", altInput: true, altFormat: "d F Y" });
        flatpickr("#tanggal_daftar", { dateFormat: "Y-m-d", maxDate: "today", locale: "id", altInput: true, altFormat: "d F Y", defaultDate: "today" });
        document.getElementById('telepon').addEventListener('input', function() {
            this.value = this.value.replace(/[^\d+]/g, '');
        });
    </script>
    @endpush
</x-app-layout>
