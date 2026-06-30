<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBukuRequest;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateBukuRequest;
use App\Exports\BukuExport;
use Maatwebsite\Excel\Facades\Excel;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $bukus = Buku::latest()->get();
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();

        return view('buku.index', compact(
            'bukus', 'totalBuku', 'bukuTersedia', 'bukuHabis'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('buku.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBukuRequest $request)
    {
        try {
            // Create buku baru dengan validated data + sinkron nama kategori
            $data = $request->validated();
            $data['kategori'] = Kategori::find($data['kategori_id'])?->nama_kategori;
            Buku::create($data);

            // Redirect dengan success message
            return redirect()->route('buku.index')
                            ->with('success', 'Buku berhasil ditambahkan!');
                            
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Gagal menambahkan buku: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $buku = Buku::findOrFail($id);
        return view('buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('buku.edit', compact('buku', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
 
/**
 * Update the specified resource in storage.
 */
public function update(UpdateBukuRequest $request, string $id)
{
    try {
        $buku = Buku::findOrFail($id);

        // Update buku dengan validated data + sinkron nama kategori
        $data = $request->validated();
        $data['kategori'] = Kategori::find($data['kategori_id'])?->nama_kategori;
        $buku->update($data);

        // Redirect dengan success message
        return redirect()->route('buku.show', $buku->id)
                         ->with('success', 'Buku berhasil diupdate!');
                         
    } catch (\Exception $e) {
        // Redirect dengan error message jika gagal
        return redirect()->back()
                         ->withInput()
                         ->with('error', 'Gagal mengupdate buku: ' . $e->getMessage());
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $buku = Buku::findOrFail($id);
            $judulBuku = $buku->judul;
            
            // Delete buku
            $buku->delete();
            
            // Redirect dengan success message
            return redirect()->route('buku.index')
                            ->with('success', "Buku '{$judulBuku}' berhasil dihapus!");
                            
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back()
                            ->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->buku_ids;

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Pilih minimal satu buku untuk dihapus.');
        }

        Buku::whereIn('id', $ids)->delete();

        return redirect()->route('buku.index')
                         ->with('success', count($ids) . ' buku berhasil dihapus!');
    }

    public function export()
    {
        return Excel::download(new BukuExport, 'buku_' . date('Y-m-d_His') . '.xlsx');
    }

    public function filterKategori($kategori)
    {
        $bukus = Buku::where('kategori', $kategori)->latest()->get();
        
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();

        return view('buku.index', compact(
            'bukus', 'totalBuku', 'bukuTersedia', 'bukuHabis'
        ));
    }
    public function search(Request $request)
    {
        $query = Buku::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                ->orWhere('pengarang', 'like', "%{$keyword}%")
                ->orWhere('penerbit', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun_terbit', $request->tahun);
        }

        if ($request->filled('ketersediaan')) {
            if ($request->ketersediaan === 'tersedia') {
                $query->where('stok', '>', 0);
            } elseif ($request->ketersediaan === 'habis') {
                $query->where('stok', '<=', 0);
            }
        }

        $bukus = $query->latest()->get();

        // Tetap kirim statistik karena view index memakainya
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();

        // Opsional: data dropdown
        $kategoriOptions = ['Programming', 'Database', 'Web Design', 'Networking', 'Data Science'];
        $tahunOptions = Buku::select('tahun_terbit')->distinct()->orderByDesc('tahun_terbit')->pluck('tahun_terbit');

        return view('buku.index', compact(
            'bukus',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis',
            'kategoriOptions',
            'tahunOptions'
        ));
    }
}
