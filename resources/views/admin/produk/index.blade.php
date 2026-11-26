<div class="row p-2">

    <div class="col-md-12">
        <div class="card">

            <div class="card-body">

                <h5><b>{{ $title }}</b></h5>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <a href="/admin/produk/create" class="btn btn-primary mb-2">
                    <i class="fas fa-plus"></i> Tambah
                </a>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th width="200">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produk as $item)
                            <tr>
                                <td>{{ $produk->firstItem() + $loop->index }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->kategori->name ?? '-' }}</td>
                                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td>
                                    @if($item->stok == 0)
                                        <span class="badge badge-danger">Habis</span>
                                    @elseif($item->stok < 10)
                                        <span class="badge badge-warning">{{ $item->stok }} - Restok!</span>
                                    @else
                                        <span class="badge badge-success">{{ $item->stok }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        {{-- Lihat --}}
                                        <a href="/admin/produk/{{ $item->id }}"
                                           class="btn btn-info btn-sm" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="/admin/produk/{{ $item->id }}/edit"
                                           class="btn btn-warning btn-sm ml-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Hapus --}}
                                        <form action="/admin/produk/{{ $item->id }}"
                                              method="POST"
                                              onsubmit="return confirm('Hapus produk ini?')">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm ml-1" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada produk</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $produk->links() }}
                </div>

            </div>

        </div>
    </div>

</div>