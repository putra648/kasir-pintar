<div class="row p-2">

    {{-- ============ KIRI: GRID PRODUK ============ --}}
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">

                <h5 class="mb-3"><b>Pilih Produk</b></h5>

                <input type="text" id="searchProduk" class="form-control mb-3"
                       placeholder="Cari produk...">

                <div class="row" id="productGrid">
                    @forelse($produk as $p)
                        <div class="col-md-4 mb-2 product-item"
                             data-nama="{{ strtolower($p->name) }}">

                            <div class="card product-card
                                {{ $p->stok == 0 ? 'border-danger' : ($p->stok < 10 ? 'border-warning' : 'border-success') }}"
                                 data-id="{{ $p->id }}"
                                 data-nama-produk="{{ $p->name }}"
                                 data-harga="{{ $p->harga }}"
                                 data-stok="{{ $p->stok }}"
                                 style="cursor: {{ $p->stok == 0 ? 'not-allowed' : 'pointer' }}; opacity: {{ $p->stok == 0 ? 0.5 : 1 }};">

                                <div class="card-body p-2">
                                    <h6 class="mb-1">{{ $p->name }}</h6>
                                    <small class="text-muted d-block">
                                        Rp {{ number_format($p->harga, 0, ',', '.') }}
                                    </small>

                                    @if($p->stok == 0)
                                        <span class="badge badge-danger mt-1">Habis</span>
                                    @elseif($p->stok < 10)
                                        <span class="badge badge-warning mt-1">
                                            Stok {{ $p->stok }} - Restok!
                                        </span>
                                    @else
                                        <span class="badge badge-success mt-1">
                                            Stok {{ $p->stok }}
                                        </span>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning">
                                Belum ada produk. Tambahkan produk dulu di
                                <a href="/admin/produk/create">menu Produk</a>.
                            </div>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

    {{-- ============ KANAN: KERANJANG ============ --}}
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">

                <h5 class="mb-3"><b>Keranjang</b></h5>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 pl-3">
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/admin/transaksi" method="POST" id="formTransaksi">
                    @csrf

                    <div class="form-group mb-3">
                        <label>Nama Pembeli</label>
                        <input type="text" name="nama_pembeli" class="form-control"
                               value="{{ old('nama_pembeli') }}" required>
                    </div>

                    <table class="table table-sm mb-2" id="cartTable">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th width="70">Qty</th>
                                <th width="110">Subtotal</th>
                                <th width="40"></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <hr>

                    <h5 class="d-flex justify-content-between mb-3">
                        <span>Total:</span>
                        <b id="totalTeks">Rp 0</b>
                    </h5>

                    <div class="form-group mb-2">
                        <label>Uang Bayar</label>
                        <input type="number" name="uang_bayar" id="uangBayar"
                               class="form-control" min="0"
                               value="{{ old('uang_bayar') }}" required>
                    </div>

                    <h5 class="d-flex justify-content-between mb-3">
                        <span>Kembalian:</span>
                        <b id="kembalianTeks" class="text-success">Rp 0</b>
                    </h5>

                    <div id="peringatanBayar" class="alert alert-warning d-none">
                        Uang bayar kurang dari total.
                    </div>

                    <button type="submit" class="btn btn-primary btn-block"
                            id="btnSubmit" disabled>
                        <i class="fas fa-save"></i> Simpan & Cetak Struk
                    </button>

                </form>

            </div>
        </div>
    </div>

</div>

<script>
(function () {
    'use strict';

    /** @type {Array<{produk_id:number,nama:string,harga:number,qty:number,stok:number}>} */
    let cart = [];

    // ---------- Klik kartu produk ----------
    document.querySelectorAll('.product-card').forEach(function (card) {
        const stok = parseInt(card.dataset.stok) || 0;
        if (stok === 0) return; // stok habis: tidak bisa diklik

        card.addEventListener('click', function () {
            addToCart(
                parseInt(card.dataset.id),
                card.dataset.namaProduk,
                parseInt(card.dataset.harga),
                stok
            );
        });
    });

    // ---------- Search produk ----------
    document.getElementById('searchProduk').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.product-item').forEach(function (el) {
            el.style.display = el.dataset.nama.includes(q) ? '' : 'none';
        });
    });

    // ---------- Tambah item ke keranjang ----------
    function addToCart(id, nama, harga, stok) {
        const existing = cart.find(function (i) { return i.produk_id === id; });

        if (existing) {
            if (existing.qty >= stok) {
                alert('Stok ' + nama + ' tidak cukup. Maksimal ' + stok + '.');
                return;
            }
            existing.qty++;
        } else {
            cart.push({ produk_id: id, nama: nama, harga: harga, qty: 1, stok: stok });
        }

        renderCart();
    }

    // ---------- Render tabel keranjang ----------
    function renderCart() {
        const tbody = document.querySelector('#cartTable tbody');
        tbody.innerHTML = '';

        if (cart.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">'
                            + 'Belum ada item</td></tr>';
        }

        let total = 0;

        cart.forEach(function (item, idx) {
            const sub = item.harga * item.qty;
            total += sub;

            const tr = document.createElement('tr');
            tr.innerHTML =
                '<td>' + item.nama +
                    '<input type="hidden" name="items[' + idx + '][produk_id]" value="' + item.produk_id + '">' +
                '</td>' +
                '<td>' +
                    '<input type="number" name="items[' + idx + '][qty]" ' +
                        'class="form-control form-control-sm qty-input" ' +
                        'min="1" max="' + item.stok + '" value="' + item.qty + '" ' +
                        'data-idx="' + idx + '">' +
                '</td>' +
                '<td>Rp ' + sub.toLocaleString('id-ID') + '</td>' +
                '<td><button type="button" class="btn btn-danger btn-sm remove-btn" ' +
                    'data-idx="' + idx + '">&times;</button></td>';

            tbody.appendChild(tr);
        });

        document.getElementById('totalTeks').textContent = 'Rp ' + total.toLocaleString('id-ID');

        // Event listener qty & remove (dipasang ulang setelah render)
        tbody.querySelectorAll('.qty-input').forEach(function (input) {
            input.addEventListener('change', function () {
                updateQty(parseInt(this.dataset.idx), parseInt(this.value) || 1);
            });
        });

        tbody.querySelectorAll('.remove-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                removeItem(parseInt(this.dataset.idx));
            });
        });

        updateKembalian(total);
    }

    function updateQty(idx, qty) {
        if (!cart[idx]) return;
        if (qty > cart[idx].stok) qty = cart[idx].stok;
        if (qty < 1) qty = 1;
        cart[idx].qty = qty;
        renderCart();
    }

    function removeItem(idx) {
        cart.splice(idx, 1);
        renderCart();
    }

    // ---------- Hitung kembalian ----------
    function hitungTotal() {
        return cart.reduce(function (sum, i) { return sum + (i.harga * i.qty); }, 0);
    }

    function updateKembalian(total) {
        const bayar = parseInt(document.getElementById('uangBayar').value) || 0;
        const kembali = bayar - total;

        document.getElementById('kembalianTeks').textContent =
            'Rp ' + Math.max(0, kembali).toLocaleString('id-ID');

        const warn = document.getElementById('peringatanBayar');
        const btn  = document.getElementById('btnSubmit');

        if (cart.length === 0) {
            warn.classList.add('d-none');
            btn.disabled = true;
            return;
        }

        if (bayar < total) {
            warn.classList.remove('d-none');
            btn.disabled = true;
        } else {
            warn.classList.add('d-none');
            btn.disabled = false;
        }
    }

    document.getElementById('uangBayar').addEventListener('input', function () {
        updateKembalian(hitungTotal());
    });

    // ---------- Init ----------
    renderCart();

})();
</script>