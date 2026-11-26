<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTransaksiController extends Controller
{
    public function index()
    {
        $data = [
            'title'     => 'Manajemen Transaksi',
            'transaksi' => Transaksi::with('user')->latest()->paginate(10),
            'content'   => 'admin/transaksi/index',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        $data = [
            'title'   => 'Buat Transaksi',
            'produk'  => Produk::orderBy('name')->get(),
            'content' => 'admin/transaksi/create',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pembeli'      => 'required|string|max:255',
            'uang_bayar'        => 'required|integer|min:0',
            'items'             => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.qty'       => 'required|integer|min:1',
        ]);

        try {
            $transaksi = DB::transaction(function () use ($request) {
                $transaksi = Transaksi::create([
                    'user_id'      => auth()->id(),
                    'kasir_name'   => auth()->user()->name,
                    'nama_pembeli' => $request->nama_pembeli,
                    'total'        => 0,
                    'uang_bayar'   => $request->uang_bayar,
                    'kembalian'    => 0,
                ]);

                $total = 0;

                foreach ($request->items as $item) {
                    $produk = Produk::lockForUpdate()->findOrFail($item['produk_id']);

                    if ($produk->stok < $item['qty']) {
                        throw new \Exception("Stok {$produk->name} tidak cukup (sisa {$produk->stok}).");
                    }

                    $subtotal = $produk->harga * $item['qty'];

                    $transaksi->details()->create([
                        'produk_id' => $produk->id,
                        'qty'       => $item['qty'],
                        'harga'     => $produk->harga,
                        'subtotal'  => $subtotal,
                    ]);

                    $produk->decrement('stok', $item['qty']);
                    $total += $subtotal;
                }

                if ($request->uang_bayar < $total) {
                    throw new \Exception('Uang bayar kurang dari total belanja.');
                }

                $transaksi->update([
                    'total'     => $total,
                    'kembalian' => $request->uang_bayar - $total,
                ]);

                return $transaksi;
            });
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect('/admin/transaksi/' . $transaksi->id . '/struk')
            ->with('success', 'Transaksi berhasil.');
    }

    public function show(string $id)
    {
        $data = [
            'title'     => 'Detail Transaksi',
            'transaksi' => Transaksi::with(['details.produk', 'user'])->findOrFail($id),
            'content'   => 'admin/transaksi/show',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function struk(string $id)
    {
        $data = [
            'title'     => 'Struk Transaksi',
            'transaksi' => Transaksi::with(['details.produk', 'user'])->findOrFail($id),
            'content'   => 'admin/transaksi/struk',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function edit(string $id)
    {
        $data = [
            'title'     => 'Edit Transaksi',
            'transaksi' => Transaksi::with('details.produk')->findOrFail($id),
            'content'   => 'admin/transaksi/edit',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function update(Request $request, string $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'uang_bayar'   => 'required|integer|min:' . $transaksi->total,
        ]);

        $transaksi->update([
            'nama_pembeli' => $request->nama_pembeli,
            'uang_bayar'   => $request->uang_bayar,
            'kembalian'    => $request->uang_bayar - $transaksi->total,
        ]);

        return redirect('/admin/transaksi/' . $transaksi->id . '/struk')
            ->with('success', 'Transaksi berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            $transaksi = Transaksi::with('details')->findOrFail($id);

            foreach ($transaksi->details as $detail) {
                Produk::where('id', $detail->produk_id)->increment('stok', $detail->qty);
            }

            $transaksi->delete();
        });

        return redirect('/admin/transaksi')->with('success', 'Transaksi dihapus, stok dikembalikan.');
    }
}