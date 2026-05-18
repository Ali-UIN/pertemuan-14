<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Dokumentasi Tugas

### Daftar Route

| Method | Path | Name | Keterangan |
| --- | --- | --- | --- |
| GET | /anggota | anggota.index | Daftar anggota |
| GET | /anggota/{id} | anggota.show | Detail anggota |
| GET | /kategori | kategori.index | Daftar kategori |
| GET | /kategori/search/{keyword} | kategori.search | Pencarian kategori |
| GET | /kategori/{id} | kategori.show | Detail kategori dan buku |

### Screenshot Hasil

Simpan gambar di folder docs/screenshots lalu tampilkan di bawah ini.

![Daftar Anggota](/docs/screenshots/anggota.png)
![Detail Anggota](/docs/screenshots/anggota-1.png)
![Daftar Kategori](/docs/screenshots/kategori.png)
![Detail Kategori](/docs/screenshots/kategori-1.png)
![Pencarian Kategori](/docs/screenshots/kategori-search.png)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
