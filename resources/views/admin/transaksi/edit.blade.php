<div class="row p-2">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">

                <h5><b>{{ $title }}</b></h5>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 pl-3">
                            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                {{-- Info transaksi (read-only) --}}
                <table class="table table-sm mb-3">
                    <tr><th width="30%">No Transaksi</th><td>#{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</td></tr>
                    <tr><th>Tanggal</th><td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td></tr>
                    <tr><th>Kasir</th><td>{{ $transaksi->kasir_name }}</td></tr>
                    <tr><th>Total</th><td><b>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</b></td></tr>
                </table>

                <h6><b>Item (tidak dapat diubah)</b></h6>
                <table class="table table-sm table-bordered mb-4">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi->details as $d)
                            <tr>
                                <td>{{ $d->produk->name ?? '(produk dihapus)' }}</td>
                                <td>Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                                <td>{{ $d->qty }}</td>
                                <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h6><b>Yang dapat diubah</b></h6>
                <form action="/admin/transaksi/{{ $transaksi->id }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label>Nama Pembeli</label>
                        <input type="text" name="nama_pembeli" class="form-control"
                               value="{{ old('nama_pembeli', $transaksi->nama_pembeli) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Uang Bayar</label>
                        <input type="number" name="uang_bayar" class="form-control"
                               min="{{ $transaksi->total }}"
                               value="{{ old('uang_bayar', $transaksi->uang_bayar) }}" required>
                        <small class="text-muted">
                            Minimal Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Transaksi
                    </button>
                    <a href="/admin/transaksi" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </form>

            </div>
        </div>
    </div>
</div>