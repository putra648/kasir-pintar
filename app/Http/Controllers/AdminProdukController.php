<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\Storage;

class AdminProdukController extends Controller
{
    public function index()
    {
        $data = [
            'title'   => 'Manajemen Produk',
            'produk'  => Produk::with('kategori')->paginate(10),
            'content' => 'admin/produk/index',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        $data = [
            'title'    => 'Tambah Produk',
            'kategori' => Kategori::get(),
            'content'  => 'admin/produk/create',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        Produk::create($validated);

        return redirect('/admin/produk')->with('success', 'Produk berhasil disimpan.');
    }

    public function show(string $id)
    {
        $produk = Produk::with('kategori')->findOrFail($id);

        $transaksiDetails = TransaksiDetail::with(['transaksi'])
            ->where('produk_id', $id)
            ->latest()
            ->paginate(10);

        $data = [
            'title'            => 'Detail Produk',
            'produk'           => $produk,
            'transaksiDetails' => $transaksiDetails,
            'content'          => 'admin/produk/show',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function tambahStok(Request $request, string $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->increment('stok', $request->jumlah);

        return redirect('/admin/produk/' . $id)
            ->with('success', 'Stok berhasil ditambahkan ' . $request->jumlah . '. Stok sekarang: ' . $produk->fresh()->stok);
    }

    public function edit(string $id)
    {
        $data = [
            'title'    => 'Edit Produk',
            'produk'   => Produk::findOrFail($id),
            'kategori' => Kategori::get(),
            'content'  => 'admin/produk/create',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function update(Request $request, string $id)
    {
        $produk = Produk::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga'       => 'required|numeric|min:0',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ⚠️ stok TIDAK di-update di sini.
        // Perubahan stok hanya lewat method tambahStok().

        if ($request->hasFile('gambar')) {
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update($validated);

        return redirect('/admin/produk')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect('/admin/produk')->with('success', 'Produk berhasil dihapus.');
    }
}