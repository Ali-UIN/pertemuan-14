## Ringkasan

- Model Buku: accessor `status_stok_badge`, `tahun_label`
- Model Buku: scope `stokMenipis`, `hargaRange`, `terbaru`
- Model Anggota: accessor `status_badge`, `kategori_usia`
- Model Anggota: scope `jenisKelamin`, `terdaftarBulanIni`

## Daftar Route

| Method | Path | Keterangan |
| --- | --- | --- |
| GET | /test-accessor-scope | Testing accessor & scope |

## Cara Uji

1. Jalankan server: `php artisan serve`
2. Buka: `http://localhost:8000/test-accessor-scope`

## Screenshot

![Tugas 1](/docs/screenshots/tugas1.png)
![Tugas 1-2](/docs/screenshots/tugas1-2.png)
![Hasil Tugas 2 - Accessor & Scope](/docs/screenshots/hasiltugas2.png)
