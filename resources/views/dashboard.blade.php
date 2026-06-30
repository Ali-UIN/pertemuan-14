<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Perpustakaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ([
                    ['Total Buku', $stats['total_buku'], 'bi-book', 'bg-blue-500'],
                    ['Anggota Aktif', $stats['total_anggota'], 'bi-people', 'bg-green-500'],
                    ['Sedang Dipinjam', $stats['sedang_dipinjam'], 'bi-journal-arrow-up', 'bg-sky-500'],
                    ['Terlambat', $stats['terlambat'], 'bi-exclamation-triangle', 'bg-red-500'],
                    ['Transaksi Hari Ini', $stats['transaksi_hari_ini'], 'bi-calendar-check', 'bg-amber-500'],
                    ['Buku Tersedia', $stats['buku_tersedia'], 'bi-bookshelf', 'bg-indigo-500'],
                    ['Total Transaksi', $stats['total_transaksi'], 'bi-receipt', 'bg-purple-500'],
                    ['Denda Bulan Ini', 'Rp ' . number_format($stats['denda_bulan_ini'], 0, ',', '.'), 'bi-cash-stack', 'bg-rose-500'],
                ] as [$label, $value, $icon, $bgClass])
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 flex items-center">
                            <div class="flex-shrink-0 {{ $bgClass }} rounded-md p-3">
                                <i class="bi {{ $icon }} text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">{{ $label }}</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $value }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Transaksi 6 Bulan Terakhir</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="chartTransaksi" height="120"></canvas>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Top 5 Buku Populer</h3>
                    </div>
                    <div class="p-6">
                        @if($bukuPopuler->where('transaksis_count', '>', 0)->count() > 0)
                            <canvas id="chartBuku" height="200"></canvas>
                        @else
                            <p class="text-sm text-gray-500 text-center py-8">Belum ada data peminjaman buku.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Charts Advanced -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Top 10 Buku Terpopuler</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="chartBukuTop10" height="120"></canvas>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Status Transaksi</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="chartStatus" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Lists -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Top 5 Buku Populer -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Buku Paling Sering Dipinjam</h3>
                    </div>
                    <div class="p-6 space-y-2">
                        @forelse($bukuPopuler as $buku)
                            <div class="flex justify-between items-center py-2 border-b border-gray-50 text-sm">
                                <span class="text-gray-700">
                                    <i class="bi bi-book text-blue-500"></i> {{ $buku->judul }}
                                </span>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold whitespace-nowrap">
                                    {{ $buku->transaksis_count }}x dipinjam
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada data.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Top 5 Anggota Aktif -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Anggota Paling Aktif</h3>
                    </div>
                    <div class="p-6 space-y-2">
                        @forelse($anggotaAktif as $anggota)
                            <div class="flex justify-between items-center py-2 border-b border-gray-50 text-sm">
                                <span class="text-gray-700">
                                    <i class="bi bi-person text-green-500"></i> {{ $anggota->nama }}
                                </span>
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold whitespace-nowrap">
                                    {{ $anggota->transaksis_count }}x transaksi
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada data.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Widget Buku Terlambat -->
            @php
                $terlambatList = \App\Models\Transaksi::with(['anggota', 'buku'])
                                    ->terlambat()
                                    ->orderBy('tanggal_kembali')
                                    ->get();
            @endphp
            <div class="bg-white shadow-sm sm:rounded-lg border-l-4 border-red-500">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-red-700">
                            <i class="bi bi-exclamation-triangle-fill"></i> Buku Terlambat
                        </h3>
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">
                            {{ $terlambatList->count() }} transaksi
                        </span>
                    </div>

                    @forelse($terlambatList as $t)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 text-sm">
                            <span>
                                <i class="bi bi-person"></i> <strong>{{ $t->anggota->nama }}</strong>
                                <span class="text-gray-500">— {{ $t->buku->judul }}</span>
                            </span>
                            <span class="text-red-600 font-medium whitespace-nowrap">
                                {{ $t->terlambat }} hari
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Tidak ada buku yang terlambat saat ini. 🎉</p>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Aksi Cepat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <a href="{{ route('buku.create') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                            <i class="bi bi-plus-circle text-blue-600 text-2xl mr-3"></i>
                            <span class="font-medium text-blue-900">Tambah Buku</span>
                        </a>
                        <a href="{{ route('anggota.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                            <i class="bi bi-person-plus text-green-600 text-2xl mr-3"></i>
                            <span class="font-medium text-green-900">Tambah Anggota</span>
                        </a>
                        <a href="{{ route('transaksi.create') }}" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                            <i class="bi bi-arrow-left-right text-yellow-600 text-2xl mr-3"></i>
                            <span class="font-medium text-yellow-900">Pinjam Buku</span>
                        </a>
                        <a href="{{ route('transaksi.laporan') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                            <i class="bi bi-file-earmark-text text-purple-600 text-2xl mr-3"></i>
                            <span class="font-medium text-purple-900">Laporan</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Transaksi Terbaru</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Anggota</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($recentTransaksi as $transaksi)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $transaksi->kode_transaksi }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $transaksi->anggota->nama }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $transaksi->buku->judul }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $transaksi->tanggal_pinjam->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaksi->status == 'Dipinjam' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $transaksi->status }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Belum ada transaksi
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    {{-- Data chart dipisahkan ke blok JSON agar script JS tetap valid --}}
    @php
        $dashboardChart = [
            'bulan'       => $chartData->pluck('bulan'),
            'pinjam'      => $chartData->pluck('pinjam'),
            'kembali'     => $chartData->pluck('kembali'),
            'bukuPopuler' => ['labels' => $bukuPopuler->pluck('judul'), 'data' => $bukuPopuler->pluck('transaksis_count')],
            'bukuTop10'   => ['labels' => $bukuTop10->pluck('judul'), 'data' => $bukuTop10->pluck('transaksis_count')],
            'status'      => ['labels' => array_keys($statusTransaksi), 'data' => array_values($statusTransaksi)],
        ];
    @endphp
    <script type="application/json" id="dashboard-chart-data">@json($dashboardChart)</script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        const chartData = JSON.parse(document.getElementById('dashboard-chart-data').textContent);

        // Line chart — Transaksi 6 bulan terakhir
        new Chart(document.getElementById('chartTransaksi'), {
            type: 'line',
            data: {
                labels: chartData.bulan,
                datasets: [
                    {
                        label: 'Peminjaman',
                        data: chartData.pinjam,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59,130,246,0.1)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Pengembalian',
                        data: chartData.kembali,
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34,197,94,0.1)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });

        // Pie chart — Top 5 buku populer
        const elBuku = document.getElementById('chartBuku');
        if (elBuku) {
            new Chart(elBuku, {
                type: 'pie',
                data: {
                    labels: chartData.bukuPopuler.labels,
                    datasets: [{
                        data: chartData.bukuPopuler.data,
                        backgroundColor: ['#3b82f6', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6']
                    }]
                },
                options: { responsive: true, plugins: { legend: { position: 'bottom', align: 'start' } } }
            });
        }

        // Bar chart — Top 10 buku terpopuler
        new Chart(document.getElementById('chartBukuTop10'), {
            type: 'bar',
            data: {
                labels: chartData.bukuTop10.labels,
                datasets: [{
                    label: 'Jumlah dipinjam',
                    data: chartData.bukuTop10.data,
                    backgroundColor: '#6366f1'
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });

        // Donut chart — Distribusi status transaksi
        new Chart(document.getElementById('chartStatus'), {
            type: 'doughnut',
            data: {
                labels: chartData.status.labels,
                datasets: [{
                    data: chartData.status.data,
                    backgroundColor: ['#f59e0b', '#22c55e']
                }]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });
    </script>
    @endpush
</x-app-layout>
