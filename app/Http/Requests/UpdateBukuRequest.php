<?php

namespace App\Http\Requests;

use App\Rules\KodeBukuFormat;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $bukuId = $this->route('buku');

        return [
            'kode_buku'    => ['required', 'string', 'max:20', 'unique:buku,kode_buku,' . $bukuId, new KodeBukuFormat],
            'judul'        => 'required|string|max:200',
            'kategori'     => 'required|in:Programming,Database,Web Design,Networking,Data Science',
            'pengarang'    => 'required|string|max:100',
            'penerbit'     => 'required|string|max:100',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'isbn'         => 'nullable|string|max:20',
            'harga'        => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
            'deskripsi'    => 'nullable|string',
            'bahasa'       => 'required|in:Indonesia,Inggris',
        ];
    }

    public function withValidator($validator): void
    {
        // Jika kategori "Programming", bahasa wajib "Inggris"
        $validator->sometimes('bahasa', 'in:Inggris', function ($input) {
            return $input->kategori === 'Programming';
        });

        // Jika tahun terbit < 2000, stok maksimal 5
        $validator->sometimes('stok', 'max:5', function ($input) {
            return (int) $input->tahun_terbit < 2000;
        });
    }

    public function messages(): array
    {
        return [
            'kode_buku.required'    => 'Kode buku wajib diisi.',
            'kode_buku.unique'      => 'Kode buku sudah digunakan, gunakan kode yang berbeda.',
            'kode_buku.max'         => 'Kode buku maksimal 20 karakter.',
            'judul.required'        => 'Judul buku wajib diisi.',
            'judul.max'             => 'Judul buku maksimal 200 karakter.',
            'kategori.required'     => 'Kategori wajib dipilih.',
            'kategori.in'           => 'Kategori yang dipilih tidak valid.',
            'pengarang.required'    => 'Nama pengarang wajib diisi.',
            'pengarang.max'         => 'Nama pengarang maksimal 100 karakter.',
            'penerbit.required'     => 'Nama penerbit wajib diisi.',
            'penerbit.max'          => 'Nama penerbit maksimal 100 karakter.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer'  => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.min'      => 'Tahun terbit tidak valid (minimal 1900).',
            'tahun_terbit.max'      => 'Tahun terbit tidak boleh melebihi tahun sekarang.',
            'isbn.max'              => 'ISBN maksimal 20 karakter.',
            'harga.required'        => 'Harga buku wajib diisi.',
            'harga.numeric'         => 'Harga harus berupa angka.',
            'harga.min'             => 'Harga tidak boleh bernilai negatif.',
            'stok.required'         => 'Stok wajib diisi.',
            'stok.integer'          => 'Stok harus berupa angka bulat.',
            'stok.min'              => 'Stok tidak boleh bernilai negatif.',
            'stok.max'              => 'Buku terbitan sebelum tahun 2000 maksimal memiliki 5 stok.',
            'bahasa.required'       => 'Bahasa wajib dipilih.',
            'bahasa.in'             => 'Buku dengan kategori Programming wajib berbahasa Inggris.',
        ];
    }

    public function attributes(): array
    {
        return [
            'kode_buku'    => 'kode buku',
            'judul'        => 'judul buku',
            'kategori'     => 'kategori',
            'pengarang'    => 'nama pengarang',
            'penerbit'     => 'nama penerbit',
            'tahun_terbit' => 'tahun terbit',
            'isbn'         => 'ISBN',
            'harga'        => 'harga',
            'stok'         => 'stok',
            'bahasa'       => 'bahasa',
        ];
    }
}
