<div class="row p-2 justify-content-center">
    <div class="col-md-4">

        <div class="card">
            <div class="card-body" id="strukArea">

                <div class="text-center mb-2">
                    <h5 class="mb-0"><b>TOKO ANDA</b></h5>
                    <small>Jl. Alamat Toko No. 123</small><br>
                    <small>Telp: 0812-3456-7890</small>
                    <hr class="my-2">
                </div>

                <small>
                    <div class="d-flex justify-content-between">
                        <span>No</span>
                        <span>{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Tanggal</span>
                        <span>{{ $transaksi->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Kasir</span>
                        <span>{{ $transaksi->kasir_name }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Pembeli</span>
                        <span>{{ $transaksi->nama_pembeli ?? '-' }}</span>
                    </div>
                </small>

                <hr class="my-2">

                @foreach($transaksi->details as $d)
                    <div class="mb-1">
                        <div>{{ $d->produk->name ?? '(produk dihapus)' }}</div>
                        <div class="d-flex justify-content-between">
                            <small>{{ $d->qty }} x Rp {{ number_format($d->harga, 0, ',', '.') }}</small>
                            <span>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach

                <hr class="my-2">

                <div class="d-flex justify-content-between">
                    <span>Total</span>
                    <b>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</b>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Bayar</span>
                    <span>Rp {{ number_format($transaksi->uang_bayar, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Kembalian</span>
                    <span>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
                </div>

                <hr class="my-2">

                <div class="text-center">
                    <small>Terima kasih atas kunjungan Anda</small><br>
                    <small>Barang yang sudah dibeli tidak dapat ditukar</small>
                </div>

            </div>
        </div>

        <div class="mt-2 no-print">
            <button class="btn btn-primary btn-block" onclick="window.print()">
                <i class="fas fa-print"></i> Cetak Struk
            </button>
            <a href="/admin/transaksi" class="btn btn-secondary btn-block">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
            <a href="/admin/transaksi/create" class="btn btn-success btn-block">
                <i class="fas fa-plus"></i> Transaksi Baru
            </a>
        </div>

    </div>
</div>

<style>
/* ====== PRINT STYLING ====== */
@media print {
    /* Sembunyikan semua elemen */
    body * {
        visibility: hidden;
    }

    /* Tampilkan hanya area struk */
    #strukArea, #strukArea * {
        visibility: visible;
    }

    /* Posisikan struk di pojok kiri atas */
    #strukArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 80mm; /* ukuran kertas struk thermal 80mm */
        padding: 0;
        margin: 0;
        font-size: 11px;
    }

    /* Sembunyikan tombol & elemen non-struk */
    .no-print,
    .sidebar,
    .navbar,
    .main-header,
    .main-footer,
    .content-header {
        display: none !important;
    }

    /* Hilangkan shadow card */
    .card {
        border: none !important;
        box-shadow: none !important;
    }

    @page {
        margin: 3mm;
        size: 80mm auto;
    }
}
</style>