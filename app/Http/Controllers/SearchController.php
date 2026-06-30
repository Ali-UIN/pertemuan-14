<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Transaksi;

class SearchController extends Controller
{
    /**
     * Global search lintas modul (Buku, Anggota, Transaksi).
     */
    public function index(Request $request)
    {
        $keyword = trim((string) $request->input('q'));
        $results = [
            'buku' => collect(),
            'anggota' => collect(),
            'transaksi' => collect(),
        ];

        if ($keyword !== '') {
            // Cari Buku berdasarkan judul, pengarang, atau ISBN
            $results['buku'] = Buku::where('judul', 'LIKE', "%{$keyword}%")
                ->orWhere('pengarang', 'LIKE', "%{$keyword}%")
                ->orWhere('isbn', 'LIKE', "%{$keyword}%")
                ->get();

            // Cari Anggota berdasarkan nama, email, atau kode anggota
            $results['anggota'] = Anggota::where('nama', 'LIKE', "%{$keyword}%")
                ->orWhere('email', 'LIKE', "%{$keyword}%")
                ->orWhere('kode_anggota', 'LIKE', "%{$keyword}%")
                ->get();

            // Cari Transaksi berdasarkan kode, nama anggota, atau judul buku
            $results['transaksi'] = Transaksi::with(['anggota', 'buku'])
                ->where('kode_transaksi', 'LIKE', "%{$keyword}%")
                ->orWhereHas('anggota', fn ($q) => $q->where('nama', 'LIKE', "%{$keyword}%"))
                ->orWhereHas('buku', fn ($q) => $q->where('judul', 'LIKE', "%{$keyword}%"))
                ->get();
        }

        return view('search.index', compact('keyword', 'results'));
    }
}
