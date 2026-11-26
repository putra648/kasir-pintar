<div class="row p-2">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">

                <h5><b>{{ $title }}</b></h5>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-sm mb-3">
                    <tr><th width="30%">No Transaksi</th><td>#{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</td></tr>
                    <tr><th>Tanggal</th><td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td></tr>
                    <tr><th>Kasir</th><td>{{ $transaksi->kasir_name }}</td></tr>
                    <tr><th>Pembeli</th><td>{{ $transaksi->nama_pembeli ?? '-' }}</td></tr>
                </table>

                <h6><b>Item yang Dibeli</b></h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi->details as $d)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $d->produk->name ?? '(produk dihapus)' }}</td>
                                <td>Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                                <td>{{ $d->qty }}</td>
                                <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-right">Bayar</th>
                            <th>Rp {{ number_format($transaksi->uang_bayar, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-right">Kembalian</th>
                            <th>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>

                <div class="mt-3">
                    <a href="/admin/transaksi/{{ $transaksi->id }}/struk" class="btn btn-success">
                        <i class="fas fa-print"></i> Cetak Struk
                    </a>
                    <a href="/admin/transaksi/{{ $transaksi->id }}/edit" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="/admin/transaksi" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>