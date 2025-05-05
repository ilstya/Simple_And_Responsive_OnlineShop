<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Pelanggan</th>
            <th>Tanggal Pesanan</th>
            <th>Total Harga</th>
            <th>Status Pesanan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pesanans as $index => $pesanan)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $pesanan->pelanggan->nama ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d M Y') }}</td>
            <td>{{ $pesanan->harga }}</td>
            <td>{{ $pesanan->status_pesanan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Pelanggan</th>
            <th>Jumlah Bayar</th>
            <th>Status Pembayaran</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $index => $pay)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $pay->pesanan->pelanggan->nama ?? '-' }}</td>
            <td>{{ $pay->jumlah }}</td>
            <td>{{ ucfirst($pay->status) }}</td>
            <td>{{ \Carbon\Carbon::parse($pay->created_at)->format('d M Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
