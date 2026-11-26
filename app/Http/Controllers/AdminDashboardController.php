<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $hariIni = now()->startOfDay();

        // Statistik utama
        $totalProduk       = Produk::count();
        $totalTransaksi    = Transaksi::count();
        $transaksiHariIni  = Transaksi::where('created_at', '>=', $hariIni)->count();
        $pendapatanHariIni = Transaksi::where('created_at', '>=', $hariIni)->sum('total');
        $pendapatanBulanIni = Transaksi::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        // Produk stok menipis (< 10) dan habis
        $produkMenipis = Produk::where('stok', '>', 0)
            ->where('stok', '<', 10)
            ->orderBy('stok')
            ->limit(5)
            ->get();

        $produkHabis = Produk::where('stok', 0)->count();

        // Transaksi terbaru
        $transaksiTerbaru = Transaksi::latest()->limit(5)->get();

        // Produk terlaris (top 5)
        $produkTerlaris = TransaksiDetail::select('produk_id', DB::raw('SUM(qty) as total_qty'))
            ->with('produk')
            ->groupBy('produk_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $data = [
            'title'              => 'Dashboard',
            'totalProduk'        => $totalProduk,
            'totalTransaksi'     => $totalTransaksi,
            'transaksiHariIni'   => $transaksiHariIni,
            'pendapatanHariIni'  => $pendapatanHariIni,
            'pendapatanBulanIni' => $pendapatanBulanIni,
            'produkMenipis'      => $produkMenipis,
            'produkHabis'        => $produkHabis,
            'transaksiTerbaru'   => $transaksiTerbaru,
            'produkTerlaris'     => $produkTerlaris,
            'content'            => 'admin/dashboard/index',
        ];

        return view('admin.layouts.wrapper', $data);
    }
}