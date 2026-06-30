<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-receipt"></i> Detail Transaksi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-sky-600 text-white flex justify-between items-center">
                    <h4 class="font-semibold"><i class="bi bi-receipt"></i> Detail Transaksi</h4>
                    <code class="text-white">{{ $transaksi->kode_transaksi }}</code>
                </div>
                <div class="p-6">
                    {{-- Reminder keterlambatan --}}
                    @if($transaksi->status == 'Dipinjam' && $transaksi->terlambat > 0)
                        <div class="mb-4 px-4 py-3 rounded-lg bg-red-100 text-red-800 border border-red-200">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <strong>Peringatan!</strong> Buku ini sudah melewati tanggal kembali
                            <strong>{{ $transaksi->terlambat }} hari</strong>.
                            Perkiraan denda saat ini:
                            <strong>Rp {{ number_format($transaksi->terlambat * 5000, 0, ',', '.') }}</strong>.
                        </div>
                    @endif

                    <dl class="divide-y divide-gray-100">
                        <div class="py-2 flex">
                            <dt class="w-56 text-sm text-gray-500">Kode Transaksi</dt>
                            <dd class="text-sm"><code class="text-indigo-600">{{ $transaksi->kode_transaksi }}</code></dd>
                        </div>
                        <div class="py-2 flex">
                            <dt class="w-56 text-sm text-gray-500">Anggota</dt>
                            <dd class="text-sm text-gray-900">{{ $transaksi->anggota->nama }} ({{ $transaksi->anggota->kode_anggota }})</dd>
                        </div>
                        <div class="py-2 flex">
                            <dt class="w-56 text-sm text-gray-500">Buku</dt>
                            <dd class="text-sm text-gray-900">{{ $transaksi->buku->judul }}</dd>
                        </div>
                        <div class="py-2 flex">
                            <dt class="w-56 text-sm text-gray-500">Tanggal Pinjam</dt>
                            <dd class="text-sm text-gray-900">{{ $transaksi->tanggal_pinjam->format('d M Y') }}</dd>
                        </div>
                        <div class="py-2 flex">
                            <dt class="w-56 text-sm text-gray-500">Tanggal Kembali (Jatuh Tempo)</dt>
                            <dd class="text-sm text-gray-900">{{ $transaksi->tanggal_kembali->format('d M Y') }}</dd>
                        </div>
                        <div class="py-2 flex">
                            <dt class="w-56 text-sm text-gray-500">Tanggal Dikembalikan</dt>
                            <dd class="text-sm text-gray-900">{{ $transaksi->tanggal_dikembalikan ? $transaksi->tanggal_dikembalikan->format('d M Y') : '-' }}</dd>
                        </div>
                        <div class="py-2 flex items-center">
                            <dt class="w-56 text-sm text-gray-500">Status</dt>
                            <dd>
                                @if($transaksi->status == 'Dipinjam')
                                <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-amber-100 text-amber-800">Dipinjam</span>
                                @else
                                <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Dikembalikan</span>
                                @endif
                            </dd>
                        </div>
                        <div class="py-2 flex">
                            <dt class="w-56 text-sm text-gray-500">Denda</dt>
                            <dd class="text-sm {{ $transaksi->denda > 0 ? 'text-red-600 font-bold' : 'text-gray-900' }}">
                                Rp {{ number_format($transaksi->denda, 0, ',', '.') }}
                                @if($transaksi->denda > 0)
                                <span class="text-xs">(terlambat {{ $transaksi->terlambat }} hari)</span>
                                @endif
                            </dd>
                        </div>
                        @if($transaksi->keterangan)
                        <div class="py-2 flex">
                            <dt class="w-56 text-sm text-gray-500">Keterangan</dt>
                            <dd class="text-sm text-gray-900">{{ $transaksi->keterangan }}</dd>
                        </div>
                        @endif
                    </dl>

                    {{-- Status pengembalian (tepat waktu / terlambat) --}}
                    @if($transaksi->status == 'Dikembalikan')
                        @if($transaksi->tanggal_dikembalikan <= $transaksi->tanggal_kembali)
                            <div class="mt-4 px-4 py-3 rounded-lg bg-green-100 text-green-800 border border-green-200">
                                <i class="bi bi-check-circle"></i> Dikembalikan tepat waktu pada
                                <strong>{{ $transaksi->tanggal_dikembalikan->format('d M Y') }}</strong>.
                            </div>
                        @else
                            <div class="mt-4 px-4 py-3 rounded-lg bg-amber-100 text-amber-800 border border-amber-200">
                                <i class="bi bi-exclamation-triangle"></i> Terlambat dikembalikan!
                                Denda: <strong>Rp {{ number_format($transaksi->denda, 0, ',', '.') }}</strong>
                                ({{ $transaksi->terlambat }} hari).
                            </div>
                        @endif
                    @endif

                    <div class="flex justify-between items-center pt-4 mt-4 border-t border-gray-100">
                        <a href="{{ route('transaksi.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 text-sm rounded-md hover:bg-gray-50">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        @if($transaksi->status == 'Dipinjam')
                        <button type="button" id="btn-kembalikan"
                            class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">
                            <i class="bi bi-arrow-return-left"></i> Kembalikan Buku
                        </button>

                        <form id="form-kembalikan" action="{{ route('transaksi.kembalikan', $transaksi->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('PUT')
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('btn-kembalikan')?.addEventListener('click', function () {
            Swal.fire({
                title: 'Konfirmasi Pengembalian',
                text: 'Apakah Anda yakin ingin mengembalikan buku ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Kembalikan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-kembalikan').submit();
                }
            });
        });
    </script>
    @endpush
</x-app-layout>