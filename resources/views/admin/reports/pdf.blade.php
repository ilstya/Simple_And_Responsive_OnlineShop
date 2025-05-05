<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th, table td { border: 1px solid #000; padding: 6px; }
        h3 { margin-bottom: 10px; }
    </style>
</head>
<body>

<h2 align="center">Laporan Transaksi Griya Jahit</h2>
<p>Periode: {{ $start ?? '-' }} s/d {{ $end ?? '-' }}</p>

<h3>Data Pesanan</h3>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Pelanggan</th>
            <th>Tanggal Pesanan</th>
            <th>Harga</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pesanans as $index => $pesanan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pesanan->pelanggan->nama ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d-m-Y') }}</td>
                <td>Rp{{ number_format($pesanan->harga, 0, ',', '.') }}</td>
                <td>{{ $pesanan->status_pesanan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h3>Data Pembayaran</h3>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Pelanggan</th>
            <th>Jumlah Dibayar</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($payments as $index => $pay)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pay->pesanan->pelanggan->nama ?? '-' }}</td>
                <td>Rp{{ number_format($pay->jumlah, 0, ',', '.') }}</td>
                <td>{{ ucfirst($pay->status) }}</td>
                <td>{{ \Carbon\Carbon::parse($pay->created_at)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
