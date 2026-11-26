<div class="row p-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <h5><b>{{ $title }}</b></h5>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <a href="/admin/transaksi/create" class="btn btn-primary mb-2">
                    <i class="fas fa-plus"></i> Buat Transaksi
                </a>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Tanggal</th>
                            <th>Kasir</th>
                            <th>Pembeli</th>
                            <th>Total</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $item->kasir_name }}</td>
                                <td>{{ $item->nama_pembeli ?? '-' }}</td>
                                <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="/admin/transaksi/{{ $item->id }}"
                                           class="btn btn-info btn-sm" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="/admin/transaksi/{{ $item->id }}/edit"
                                           class="btn btn-warning btn-sm ml-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/admin/transaksi/{{ $item->id }}/struk"
                                           class="btn btn-success btn-sm ml-1" title="Struk">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <form action="/admin/transaksi/{{ $item->id }}"
                                              method="POST"
                                              onsubmit="return confirm('Hapus transaksi? Stok akan dikembalikan.')">
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
                                <td colspan="6" class="text-center">Belum ada transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $transaksi->links() }}
                </div>

            </div>
        </div>
    </div>
</div>