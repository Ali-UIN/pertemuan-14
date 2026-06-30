<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-search"></i> Hasil Pencarian
        </h2>
    </x-slot>

    @php
        // Helper highlight keyword (aman dari XSS karena di-escape dulu)
        $highlight = function ($text) use ($keyword) {
            $escaped = e($text);
            if ($keyword === '') {
                return $escaped;
            }
            return str_ireplace(e($keyword), '<mark>' . e($keyword) . '</mark>', $escaped);
        };
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6"
                 x-data="{ tab: 'buku' }">

                @if($keyword === '')
                    <p class="text-gray-500">Masukkan kata kunci pada kotak pencarian di atas.</p>
                @else
                    <p class="mb-4 text-gray-600">
                        Menampilkan hasil untuk: <strong>"{{ $keyword }}"</strong>
                    </p>

                    {{-- Tabs --}}
                    <div class="border-b border-gray-200 mb-4">
                        <nav class="-mb-px flex space-x-6 text-sm font-medium">
                            <button @click="tab = 'buku'"
                                :class="tab === 'buku' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                class="py-3 px-1 border-b-2">
                                Buku ({{ $results['buku']->count() }})
                            </button>
                            <button @click="tab = 'anggota'"
                                :class="tab === 'anggota' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                class="py-3 px-1 border-b-2">
                                Anggota ({{ $results['anggota']->count() }})
                            </button>
                            <button @click="tab = 'transaksi'"
                                :class="tab === 'transaksi' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                class="py-3 px-1 border-b-2">
                                Transaksi ({{ $results['transaksi']->count() }})
                            </button>
                        </nav>
                    </div>

                    {{-- Tab Buku --}}
                    <div x-show="tab === 'buku'" class="space-y-2">
                        @forelse($results['buku'] as $buku)
                            <a href="{{ route('buku.show', $buku->id) }}"
                               class="block border border-gray-100 rounded-lg p-4 hover:bg-gray-50 transition">
                                <h6 class="font-semibold text-gray-800">{!! $highlight($buku->judul) !!}</h6>
                                <small class="text-gray-500">
                                    <i class="bi bi-person"></i> {{ $buku->pengarang }} — Stok: {{ $buku->stok }}
                                </small>
                            </a>
                        @empty
                            <p class="text-gray-500">Tidak ada buku yang cocok.</p>
                        @endforelse
                    </div>

                    {{-- Tab Anggota --}}
                    <div x-show="tab === 'anggota'" class="space-y-2" style="display: none;">
                        @forelse($results['anggota'] as $anggota)
                            <a href="{{ route('anggota.show', $anggota->id) }}"
                               class="block border border-gray-100 rounded-lg p-4 hover:bg-gray-50 transition">
                                <h6 class="font-semibold text-gray-800">{!! $highlight($anggota->nama) !!}</h6>
                                <small class="text-gray-500">
                                    {{ $anggota->kode_anggota }} — {{ $anggota->email }}
                                </small>
                            </a>
                        @empty
                            <p class="text-gray-500">Tidak ada anggota yang cocok.</p>
                        @endforelse
                    </div>

                    {{-- Tab Transaksi --}}
                    <div x-show="tab === 'transaksi'" class="space-y-2" style="display: none;">
                        @forelse($results['transaksi'] as $trx)
                            <a href="{{ route('transaksi.show', $trx->id) }}"
                               class="block border border-gray-100 rounded-lg p-4 hover:bg-gray-50 transition">
                                <h6 class="font-semibold text-gray-800">{!! $highlight($trx->kode_transaksi) !!}</h6>
                                <small class="text-gray-500">
                                    {{ $trx->anggota->nama ?? '-' }} — {{ $trx->buku->judul ?? '-' }}
                                </small>
                            </a>
                        @empty
                            <p class="text-gray-500">Tidak ada transaksi yang cocok.</p>
                        @endforelse
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
