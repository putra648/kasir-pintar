<div class="row p-2">

    {{-- ============ KIRI: INFO PRODUK ============ --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">

                <h5><b>{{ $title }}</b></h5>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($produk->gambar)
                    <div class="text-center mb-3">
                        <img src="{{ asset('storage/' . $produk->gambar) }}"
                             alt="{{ $produk->name }}"
                             class="img-fluid rounded" style="max-height: 200px;">
                    </div>
                @endif

                <table class="table table-sm">
                    <tr>
                        <th width="35%">Nama</th>
                        <td>{{ $produk->name }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $produk->kategori->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td>
                            @if($produk->stok == 0)
                                <span class="badge badge-danger">Habis</span>
                            @elseif($produk->stok < 10)
                                <span class="badge badge-warning">
                                    {{ $produk->stok }} - Restok!
                                </span>
                            @else
                                <span class="badge badge-success">{{ $produk->stok }}</span>
                            @endif
                        </td>
                    </tr>
                </table>

                <hr>

                <h6><b>Tambah Stok</b></h6>
                <form action="/admin/produk/{{ $produk->id }}/tambah-stok" method="POST">
                    @csrf
                    <div class="form-group mb-2">
                        <input type="number" name="jumlah" class="form-control"
                               min="1" value="10" required>
                        <small class="text-muted">Jumlah stok yang ditambahkan</small>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-plus"></i> Tambah Stok
                    </button>
                </form>

                <hr>

                <a href="/admin/produk/{{ $produk->id }}/edit" class="btn btn-warning btn-block">
                    <i class="fas fa-edit"></i> Edit Produk
                </a>
                <a href="/admin/produk" class="btn btn-secondary btn-block">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>

            </div>
        </div>
    </div>

    {{-- ============ KANAN: RIWAYAT TRANSAKSI ============ --}}
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">

                <h5><b>Riwayat Transaksi Produk Ini</b></h5>
                <p class="text-muted mb-2">
                    Daftar transaksi yang <b>mengurangi stok</b> produk ini.
                    Klik baris untuk membuka detail transaksi.
                </p>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Tanggal</th>
                            <th>No Transaksi</th>
                            <th>Kasir</th>
                            <th>Pembeli</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksiDetails as $d)
                            <tr style="cursor: pointer;"
                                onclick="window.location='/admin/transaksi/{{ $d->transaksi->id }}'">
                                <td>{{ $transaksiDetails->firstItem() + $loop->index }}</td>
                                <td>{{ $d->transaksi->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="/admin/transaksi/{{ $d->transaksi->id }}">
                                        #{{ str_pad($d->transaksi->id, 6, '0', STR_PAD_LEFT) }}
                                    </a>
                                </td>
                                <td>{{ $d->transaksi->kasir_name }}</td>
                                <td>{{ $d->transaksi->nama_pembeli ?? '-' }}</td>
                                <td>{{ $d->qty }}</td>
                                <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Belum ada transaksi yang menggunakan produk ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $transaksiDetails->links() }}
                </div>

            </div>
        </div>
    </div>

</div>