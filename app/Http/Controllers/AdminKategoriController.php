<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class AdminKategoriController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Manajemen Kategori',
            'kategori' => Kategori::orderBy('id', 'desc')->paginate(30),
            'content' => 'admin.kategori.index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kategori',
            'content' => 'admin.kategori.create'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Kategori::create([
            'name' => $request->name
        ]);

        return redirect('/admin/kategori')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Kategori',
            'kategori' => Kategori::findOrFail($id),
            'content' => 'admin.kategori.create'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $kategori = Kategori::findOrFail($id);

        $kategori->update([
            'name' => $request->name
        ]);

        return redirect('/admin/kategori')
            ->with('success', 'Kategori berhasil diubah!');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect('/admin/kategori')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}