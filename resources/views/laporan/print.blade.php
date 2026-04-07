<!DOCTYPE html>
<html>

<head>
    <title>Laporan Peminjaman Buku</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #ccc;
            margin: 0;
        }

        /* WRAPPER untuk efek tengah */
        .wrapper {
            display: flex;
            justify-content: center;
            padding: 40px 0;
        }

        /* KERTAS */
        .container {
            background: white;
            width: 210mm;
            min-height: 297mm;
            padding: 25mm;

            /* 🔥 ini kuncinya */
            transform: scale(0.75);
            transform-origin: top center;

            box-shadow: 0 0 20px rgba(0,0,0,0.3);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
        }

        th {
            background: #eee;
        }

        /* tombol */
        .actions {
            position: fixed;
            right: 20px;
            top: 20px;
        }

        .actions button,
        .actions a {
            padding: 10px 15px;
            margin-left: 5px;
            cursor: pointer;
            border: none;
            text-decoration: none;
            background: #333;
            color: white;
            border-radius: 5px;
        }

        .actions a {
            background: gray;
        }

        /* PRINT MODE */
        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            body {
                background: white;
            }

            .wrapper {
                padding: 0;
            }

            .container {
                transform: scale(1); /* 🔥 balik normal */
                width: 210mm;
                min-height: 297mm;
                margin: 0;
                box-shadow: none;
            }

            .actions {
                display: none;
            }
        }
    </style>

</head>

<body>

    <!-- tombol -->
    <div class="actions">
        <button onclick="printPage()">🖨 Cetak Laporan</button>
        <a href="{{ url()->previous() }}">← Kembali</a>
    </div>

    <div class="wrapper">
        <div class="container">

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
                    @foreach ($transactions as $item)
                        <tr>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->book->judul }}</td>
                            <td>{{ $item->tanggal_pinjam }} - {{ $item->tanggal_kembali }}</td>
                            <td>{{ $item->status }}</td>
                            <td>Rp {{ number_format($item->denda, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

    <script>
        function printPage() {
            window.print();
        }
    </script>

</body>

</html>