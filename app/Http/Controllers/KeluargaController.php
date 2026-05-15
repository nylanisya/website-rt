<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use Illuminate\Http\Request;

class KeluargaController extends Controller
{
    public function index()
    {
        $keluargas = Keluarga::all();
        return view('keluarga.index', compact('keluargas'));
    }

    public function create()
    {
        return view('keluarga.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_kk' => 'required|unique:keluargas',
            'kepala_keluarga' => 'required',
            'alamat' => 'required',
            'rt' => 'required',
            'rw' => 'required',
        ]);

        Keluarga::create($request->all());
        return redirect()->route('keluarga.index')->with('success', 'Data KK berhasil ditambahkan');
    }

    public function edit(Keluarga $keluarga)
    {
        return view('keluarga.edit', compact('keluarga'));
    }

    public function update(Request $request, Keluarga $keluarga)
    {
        $request->validate([
            'no_kk' => 'required|unique:keluargas,no_kk,' . $keluarga->id,
            'kepala_keluarga' => 'required',
            'alamat' => 'required',
            'rt' => 'required',
            'rw' => 'required',
        ]);

        $keluarga->update($request->all());
        return redirect()->route('keluarga.index')->with('success', 'Data KK berhasil diupdate');
    }

    public function destroy(Keluarga $keluarga)
    {
        $keluarga->delete();
        return redirect()->route('keluarga.index')->with('success', 'Data KK berhasil dihapus');
    }
}