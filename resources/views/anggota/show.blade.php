<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/anggota">Anggota</a></li>
                <li class="breadcrumb-item active">{{ $anggota['nama'] }}</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Detail Anggota</h3>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="180">Kode Anggota</th>
                        <td>: {{ $anggota['kode'] }}</td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>: {{ $anggota['nama'] }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>: {{ $anggota['email'] }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>: {{ $anggota['telepon'] }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>: {{ $anggota['alamat'] }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>:
                            @if ($anggota['status'] == 'Aktif')
                                <span class="badge bg-success">{{ $anggota['status'] }}</span>
                            @else
                                <span class="badge bg-danger">{{ $anggota['status'] }}</span>
                            @endif
                        </td>
                    </tr>
                </table>

                <a href="/anggota" class="btn btn-secondary">Kembali ke Daftar</a>
            </div>
        </div>
    </div>
</body>
</html>