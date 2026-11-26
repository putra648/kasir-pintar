
<div class="row p-2">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">

                <h5 class="mb-4">
                    <b>{{ $title }}</b>
                </h5>

                @php
                    $isEdit = isset($kategori);
                @endphp

                <form action="{{ $isEdit
                    ? url('/admin/kategori/' . $kategori->id)
                    : url('/admin/kategori') }}"
                    method="POST">

                    @csrf

                    @if($isEdit)
                        @method('PUT')
                    @endif

                    <div class="form-group mb-3">
                        <label for="name">Nama Kategori</label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Masukkan nama kategori"
                            value="{{ old('name', $kategori->name ?? '') }}"
                            required
                        >

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        {{ $isEdit ? 'Update' : 'Simpan' }}
                    </button>

                    <a href="{{ url('/admin/kategori') }}"
                       class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>

                </form>

            </div>
        </div>
    </div>
</div>
