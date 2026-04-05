<!DOCTYPE html>
<html>
<head>
    <title>Laporan</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>

    <h2>Laporan Peminjaman Buku</h2>

    <table>
        <thead>
            <tr>
                <th>Siswa</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $t)
            <tr>
                <td>{{ $t->user->name }}</td>
                <td>{{ $t->book->judul }}</td>
                <td>{{ $t->tanggal_pinjam }} - {{ $t->tanggal_kembali }}</td>
                <td>{{ $t->status }}</td>
                <td>Rp {{ number_format($t->denda) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>