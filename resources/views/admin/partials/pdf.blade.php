<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Inventory</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f3f3f3;
        }

        tr {
            page-break-inside: avoid;
        }

        h1,
        p {
            text-align: center;
            margin: 0;
        }

        p {
            margin-bottom: 10px;
            font-size: 11px;
            color: #555;
        }
    </style>
</head>

<body>

    <h1>Laporan Inventory {{ $periode ?? '' }}</h1>
    <p>Periode: {{ $periodeText }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Level Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $item)
            @php
            $kategori = strtolower($item->item_type) === 'produk' ? 'Es Krim' : 'Perlengkapan';
            @endphp
            <tr>
                <td>{{ \Carbon\Carbon::parse($item->recorded_at)->format('d/m/Y') }}</td>
                <td>{{ $item->nama_item }}</td>
                <td>{{ $kategori }}</td>
                <td>
                    {{ $item->stok }}
                    {{ strtolower($item->item_type) === 'produk' ? '%' : ' pcs' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>