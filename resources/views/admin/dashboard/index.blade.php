<div class="row p-2">

    {{-- ============ KARTU STATISTIK ============ --}}
    <div class="col-md-3 mb-2">
        <div class="card stat-card stat-card--indigo">
            <div class="card-body">
                <div class="stat-label">Total Produk</div>
                <div class="stat-value">{{ $totalProduk }}</div>
                <i class="stat-icon fas fa-box"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-2">
        <div class="card stat-card stat-card--teal">
            <div class="card-body">
                <div class="stat-label">Pendapatan Hari Ini</div>
                <div class="stat-value">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
                <i class="stat-icon fas fa-coins"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-2">
        <div class="card stat-card stat-card--sky">
            <div class="card-body">
                <div class="stat-label">Transaksi Hari Ini</div>
                <div class="stat-value">{{ $transaksiHariIni }}</div>
                <i class="stat-icon fas fa-receipt"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-2">
        <div class="card stat-card stat-card--amber">
            <div class="card-body">
                <div class="stat-label">Pendapatan Bulan Ini</div>
                <div class="stat-value">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
                <i class="stat-icon fas fa-chart-line"></i>
            </div>
        </div>
    </div>

    {{-- ============ PRODUK STOK MENIPIS ============ --}}
    <div class="col-md-6 mb-2">
        <div class="card">
            <div class="card-body">
                <h5><b><i class="fas fa-exclamation-triangle text-warning"></i> Produk Stok Menipis</b></h5>

                @if($produkHabis > 0)
                    <div class="alert alert-danger py-2">
                        <b>{{ $produkHabis }}</b> produk <b>HABIS</b> — segera restok!
                    </div>
                @endif

                @if($produkMenipis->isEmpty())
                    <p class="text-muted mb-0">Semua produk stoknya aman.</p>
                @else
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr><th>Produk</th><th width="80">Stok</th><th width="80"></th></tr>
                        </thead>
                        <tbody>
                            @foreach($produkMenipis as $p)
                                <tr>
                                    <td>{{ $p->name }}</td>
                                    <td>
                                        <span class="badge badge-warning">{{ $p->stok }}</span>
                                    </td>
                                    <td>
                                        @if(auth()->user()?->isAdmin())
                                            <a href="/admin/produk/{{ $p->id }}"
                                               class="btn btn-sm btn-success">
                                                <i class="fas fa-plus"></i> Restok
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    {{-- ============ PRODUK TERLARIS ============ --}}
    <div class="col-md-6 mb-2">
        <div class="card">
            <div class="card-body">
                <h5><b><i class="fas fa-fire text-danger"></i> Produk Terlaris</b></h5>

                @if($produkTerlaris->isEmpty())
                    <p class="text-muted mb-0">Belum ada penjualan.</p>
                @else
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr><th>Produk</th><th width="100">Terjual</th></tr>
                        </thead>
                        <tbody>
                            @foreach($produkTerlaris as $pt)
                                <tr>
                                    <td>{{ $pt->produk->name ?? '(produk dihapus)' }}</td>
                                    <td><b>{{ $pt->total_qty }}</b> pcs</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    {{-- ============ TRANSAKSI TERBARU ============ --}}
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5><b><i class="fas fa-receipt text-info"></i> Transaksi Terbaru</b></h5>

                @if($transaksiTerbaru->isEmpty())
                    <p class="text-muted mb-0">Belum ada transaksi.</p>
                @else
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kasir</th>
                                <th>Pembeli</th>
                                <th>Total</th>
                                <th width="80"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksiTerbaru as $t)
                                <tr>
                                    <td>#{{ str_pad($t->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $t->kasir_name }}</td>
                                    <td>{{ $t->nama_pembeli ?? '-' }}</td>
                                    <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="/admin/transaksi/{{ $t->id }}"
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <a href="/admin/transaksi" class="btn btn-sm btn-primary mt-2">
                        Lihat Semua Transaksi <i class="fas fa-arrow-right"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>

</div>