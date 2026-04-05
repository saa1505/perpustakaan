<!DOCTYPE html>
<html>

<head>
    <title>Print</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container-print {
            width: 60%;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
        }

        @media print {
            body {
                margin: 0;
            }

            .container-print {
                width: 60% !important;
                margin: 0 auto !important;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="container-print">
        <h2 style="text-align:center;">Laporan Peminjaman Buku</h2>

        <table>
            <tr>
                <th>Siswa</th>
                <th>Buku</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>

            @foreach ($transactions as $t)
                <tr>
                    <td>{{ $t->user->name }}</td>
                    <td>{{ $t->book->judul }}</td>
                    <td>{{ $t->tanggal_pinjam }} - {{ $t->tanggal_kembali }}</td>
                    <td>{{ $t->status }}</td>
                    <td>Rp {{ $t->denda }}</td>
                </tr>
            @endforeach
        </table>
    </div>

</body>

</html>
