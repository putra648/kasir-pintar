
<div class="row p-2">
    <div class="col-md-12">

        <div class="card shadow-sm">
            <div class="card-body">

                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <b>{{ $title }}</b>
                    </h5>

                    <a href="{{ url('/admin/kategori/create') }}"
                       class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Tambah Kategori
                    </a>
                </div>

                {{-- Notifikasi sukses --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}

                        <button type="button" class="close"
                                data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                @endif

                {{-- Notifikasi error --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Tabel kategori --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">

                        <thead class="thead-light">
                            <tr>
                                <th width="60">No</th>
                                <th>Nama Kategori</th>
                                <th width="150" class="text-center">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($kategori as $item)

                                <tr>
                                    <td>
                                        {{ $kategori->firstItem() + $loop->index }}
                                    </td>

                                    <td>
                                        {{ $item->name }}
                                    </td>

                                    <td class="text-center">

                                        {{-- Edit --}}
                                        <a href="{{ url('/admin/kategori/' . $item->id . '/edit') }}"
                                           class="btn btn-info btn-sm"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Hapus --}}
                                        <form
                                            action="{{ url('/admin/kategori/' . $item->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                        </form>

                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="3"
                                        class="text-center text-muted py-4">
                                        <i class="fas fa-folder-open fa-2x mb-2"></i>
                                        <p class="mb-0">
                                            Belum ada kategori.
                                        </p>
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-end">
                    {{ $kategori->links() }}
                </div>

            </div>
        </div>

    </div>
</div>
