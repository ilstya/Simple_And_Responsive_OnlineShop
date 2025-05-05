<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi Pembayaran</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; }
        .content { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Griya Jahit</h2>
        <h4>Kwitansi Pembayaran</h4>
        <hr>
    </div>

    <div class="content">
        <p><strong>Nama:</strong> {{ $pesanan->pelanggan->nama }}</p>
        <p><strong>Email:</strong> {{ $pesanan->pelanggan->email }}</p>
        <p><strong>Alamat:</strong> {{ $pesanan->pelanggan->alamat }}</p>
        <p><strong>Tanggal Pesan:</strong> {{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d M Y') }}</p>
        <p><strong>Status Pesanan:</strong> {{ $pesanan->status_pesanan }}</p>
        <p><strong>Jumlah Bayar:</strong> Rp{{ number_format($pesanan->pembayaran->jumlah, 0, ',', '.') }}</p>

        <br>
        <p><em>Terima kasih telah melakukan pembayaran.</em></p>
    </div>
</body>
</html>
