<div class="row p-2">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">

                @php
                    $isEdit = isset($produk);
                @endphp

                <h5 class="mb-4">
                    <b>{{ $title ?? ($isEdit ? 'Edit Produk' : 'Tambah Produk') }}</b>
                </h5>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form
                    action="{{ $isEdit ? url('/admin/produk/' . $produk->id) : url('/admin/produk') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf

                    @if($isEdit)
                        @method('PUT')
                    @endif

                    {{-- ===== NAMA ===== --}}
                    <div class="form-group mb-3">
                        <label>Nama Produk</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Masukkan nama produk"
                            value="{{ old('name', $produk->name ?? '') }}"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ===== KATEGORI ===== --}}
                    <div class="form-group mb-3">
                        <label>Kategori</label>
                        <select
                            name="kategori_id"
                            class="form-control @error('kategori_id') is-invalid @enderror"
                            required
                        >
                            <option value="">-- Pilih Kategori --</option>

                            @forelse(($kategori ?? []) as $item)
                                <option
                                    value="{{ $item->id }}"
                                    {{ old('kategori_id', $produk->kategori_id ?? '') == $item->id ? 'selected' : '' }}
                                >
                                    {{ $item->name }}
                                </option>
                            @empty
                                <option value="" disabled>Belum ada kategori</option>
                            @endforelse
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ===== HARGA ===== --}}
                    <div class="form-group mb-3">
                        <label>Harga</label>
                        <input
                            type="number"
                            name="harga"
                            class="form-control @error('harga') is-invalid @enderror"
                            placeholder="Masukkan harga produk"
                            value="{{ old('harga', $produk->harga ?? '') }}"
                            min="0"
                            required
                        >
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ===== STOK ===== --}}
                    @if($isEdit)
                        {{-- Mode EDIT: stok read-only --}}
                        <div class="form-group mb-3">
                            <label>Stok Saat Ini</label>

                            <div class="d-flex align-items-center p-3 rounded
                                {{ $produk->stok == 0
                                    ? 'border border-danger bg-light'
                                    : ($produk->stok < 10
                                        ? 'border border-warning bg-light'
                                        : 'border border-success bg-light') }}">

                                <div class="flex-grow-1">
                                    @if($produk->stok == 0)
                                        <span class="badge badge-danger p-2" style="font-size: 14px;">
                                            <i class="fas fa-times-circle"></i> Habis (0)
                                        </span>
                                    @elseif($produk->stok < 10)
                                        <span class="badge badge-warning p-2" style="font-size: 14px;">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            Stok Menipis: {{ $produk->stok }}
                                        </span>
                                    @else
                                        <span class="badge badge-success p-2" style="font-size: 14px;">
                                            <i class="fas fa-check-circle"></i>
                                            Stok: {{ $produk->stok }}
                                        </span>
                                    @endif

                                    <small class="text-muted d-block mt-2">
                                        <i class="fas fa-info-circle"></i>
                                        Stok tidak dapat diubah langsung di sini.
                                        Gunakan form <b>Tambah Stok</b> di bawah.
                                    </small>
                                </div>

                            </div>
                        </div>
                    @else
                        {{-- Mode CREATE: input stok awal --}}
                        <div class="form-group mb-3">
                            <label>Stok Awal</label>
                            <input
                                type="number"
                                name="stok"
                                class="form-control @error('stok') is-invalid @enderror"
                                placeholder="Masukkan jumlah stok awal"
                                value="{{ old('stok', 0) }}"
                                min="0"
                                required
                            >
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Stok awal saat produk pertama kali dibuat.
                            </small>
                        </div>
                    @endif

                    {{-- ===== GAMBAR ===== --}}
                        <div class="form-group mb-4">
                            <label>Gambar Produk</label>
                            <input
                                type="file"
                                name="gambar"
                                class="form-control-file @error('gambar') is-invalid @enderror"
                                accept="image/*"
                            >
                        </div>

                            @if($isEdit && !empty($produk->gambar))
                            <div class="mt-2">
                                <img
                                    src="{{ asset('storage/' . $produk->gambar) }}"
                                    alt="Gambar Produk"
                                    width="100"
                                    class="rounded"
                                >
                            </div>
                        @endif

                        @error('gambar')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        {{ $isEdit ? 'Update Produk' : 'Simpan Produk' }}
                    </button>

                    <a href="{{ url('/admin/produk') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </form>

                {{-- ===== FORM TAMBAH STOK (hanya edit) ===== --}}
                @if($isEdit)
                    <hr class="my-4">

                    <h6 class="mb-2">
                        <b><i class="fas fa-plus-circle text-success"></i> Tambah Stok</b>
                    </h6>
                    <p class="text-muted small mb-3">
                        Tambahkan stok tanpa mengubah data produk lainnya.
                        Stok akan otomatis bertambah sesuai jumlah yang diisi.
                    </p>

                    <form action="/admin/produk/{{ $produk->id }}/tambah-stok" method="POST">
                        @csrf

                        <div class="input-group" style="max-width: 400px;">
                            <input
                                type="number"
                                name="jumlah"
                                class="form-control"
                                min="1"
                                value="10"
                                required
                                placeholder="Jumlah stok yang ditambahkan"
                            >
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Tambah Stok
                                </button>
                            </div>
                        </div>

                        <small class="text-muted d-block mt-2">
                            Contoh: isi <b>10</b> → stok saat ini
                            (<b>{{ $produk->stok }}</b>) akan menjadi
                            <b>{{ $produk->stok + 10 }}</b>.
                        </small>
                    </form>
                @endif

            </div>
        </div>
    </div>
</div>