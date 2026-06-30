<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Tampilkan daftar kategori beserta jumlah buku.
     */
    public function index(Request $request)
    {
        $query = Kategori::withCount('bukus');

        if ($request->filled('q')) {
            $keyword = $request->input('q');
            $query->where('nama_kategori', 'LIKE', "%{$keyword}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$keyword}%");
        }

        $kategori_list = $query->orderBy('nama_kategori')->get();

        return view('kategori.index', compact('kategori_list'));
    }

    /**
     * Form tambah kategori.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:kategori,nama_kategori',
            'deskripsi'     => 'nullable|string',
            'icon'          => 'nullable|string|max:50',
            'warna'         => 'nullable|string|max:20',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah ada.',
        ]);

        Kategori::create($validated);

        return redirect()->route('kategori.index')
                         ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail kategori beserta daftar bukunya.
     */
    public function show(string $id)
    {
        $kategori = Kategori::withCount('bukus')->findOrFail($id);
        $buku_list = $kategori->bukus()->latest()->get();

        return view('kategori.show', compact('kategori', 'buku_list'));
    }

    /**
     * Form edit kategori.
     */
    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update kategori.
     */
    public function update(Request $request, string $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:kategori,nama_kategori,' . $kategori->id,
            'deskripsi'     => 'nullable|string',
            'icon'          => 'nullable|string|max:50',
            'warna'         => 'nullable|string|max:20',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah ada.',
        ]);

        $kategori->update($validated);

        // Sinkronkan kolom string 'kategori' pada buku terkait
        $kategori->bukus()->update(['kategori' => $kategori->nama_kategori]);

        return redirect()->route('kategori.index')
                         ->with('success', 'Kategori berhasil diupdate!');
    }

    /**
     * Hapus kategori (jika tidak memiliki buku).
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::withCount('bukus')->findOrFail($id);

        if ($kategori->bukus_count > 0) {
            return redirect()->route('kategori.index')
                             ->with('error', "Kategori '{$kategori->nama_kategori}' tidak bisa dihapus karena masih memiliki {$kategori->bukus_count} buku.");
        }

        $nama = $kategori->nama_kategori;
        $kategori->delete();

        return redirect()->route('kategori.index')
                         ->with('success', "Kategori '{$nama}' berhasil dihapus!");
    }
}
