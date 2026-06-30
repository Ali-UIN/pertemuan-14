<?php

namespace App\Http\Controllers;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard dengan statistik, grafik, dan data terbaru.
     */
    public function index()
    {
        // Statistik utama
        $stats = [
            'total_buku'         => Buku::count(),
            'total_anggota'      => Anggota::where('status', 'Aktif')->count(),
            'total_transaksi'    => Transaksi::count(),
            'sedang_dipinjam'    => Transaksi::where('status', 'Dipinjam')->count(),
            'terlambat'          => Transaksi::where('status', 'Dipinjam')
                                             ->whereDate('tanggal_kembali', '<', now())->count(),
            'denda_bulan_ini'    => Transaksi::whereMonth('tanggal_dikembalikan', now()->month)
                                             ->whereYear('tanggal_dikembalikan', now()->year)
                                             ->sum('denda'),
            'transaksi_hari_ini' => Transaksi::whereDate('tanggal_pinjam', today())->count(),
            'buku_tersedia'      => Buku::where('stok', '>', 0)->count(),
        ];

        // Data chart: transaksi 6 bulan terakhir
        $chartData = collect(range(5, 0))->map(function ($i) {
            $date = now()->subMonths($i);
            return [
                'bulan'   => $date->translatedFormat('M Y'),
                'pinjam'  => Transaksi::whereMonth('tanggal_pinjam', $date->month)
                                      ->whereYear('tanggal_pinjam', $date->year)->count(),
                'kembali' => Transaksi::whereMonth('tanggal_dikembalikan', $date->month)
                                      ->whereYear('tanggal_dikembalikan', $date->year)->count(),
            ];
        });

        // Top 5 buku populer (paling sering dipinjam)
        $bukuPopuler = Buku::withCount('transaksis')
                           ->orderByDesc('transaksis_count')
                           ->take(5)->get();

        // Top 10 buku terpopuler (untuk bar chart)
        $bukuTop10 = Buku::withCount('transaksis')
                         ->orderByDesc('transaksis_count')
                         ->take(10)->get();

        // Distribusi status transaksi (untuk donut chart)
        $statusTransaksi = [
            'Dipinjam'     => Transaksi::where('status', 'Dipinjam')->count(),
            'Dikembalikan' => Transaksi::where('status', 'Dikembalikan')->count(),
        ];

        // Top 5 anggota paling aktif
        $anggotaAktif = Anggota::withCount('transaksis')
                               ->orderByDesc('transaksis_count')
                               ->take(5)->get();

        // Transaksi terbaru
        $recentTransaksi = Transaksi::with(['anggota', 'buku'])
                                    ->latest()->take(5)->get();

        return view('dashboard', compact(
            'stats',
            'chartData',
            'bukuPopuler',
            'bukuTop10',
            'statusTransaksi',
            'anggotaAktif',
            'recentTransaksi'
        ));
    }
}
