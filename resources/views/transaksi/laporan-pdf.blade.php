<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h2 { text-align: center; margin-bottom: 2px; }
        p.sub { text-align: center; margin-top: 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #999; padding: 6px 8px; text-align: left; }
        th { background: #f0f0f0; }
        .text-right { text-align: right; }
        .summary { margin-top: 15px; font-size: 13px; }
        .summary strong { display: inline-block; width: 140px; }
    </style>
</head>
<body>
    <h2>LAPORAN TRANSAKSI PERPUSTAKAAN</h2>
    <p class="sub">Dicetak: {{ now()->format('d M Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Pinjam</th>
                <th>Kembali</th>
                <th>Status</th>
                <th class="text-right">Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $transaksi)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaksi->kode_transaksi }}</td>
                    <td>{{ $transaksi->anggota->nama }}</td>
                    <td>{{ $transaksi->buku->judul }}</td>
                    <td>{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>
                    <td>{{ $transaksi->tanggal_kembali->format('d M Y') }}</td>
                    <td>{{ $transaksi->status }}</td>
                    <td class="text-right">Rp {{ number_format($transaksi->denda, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="8" style="text-align:center">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <p><strong>Total Transaksi</strong>: {{ $transaksis->count() }}</p>
        <p><strong>Total Denda</strong>: Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
    </div>
</body>
</html>
