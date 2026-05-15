<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\Keluarga;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    public function index()
    {
        $wargas = Warga::with('keluarga')->get();
        return view('warga.index', compact('wargas'));
    }

    public function create()
    {
        $keluargas = Keluarga::all();
        return view('warga.create', compact('keluargas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keluarga_id' => 'required',
            'nik' => 'required|unique:wargas',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'status_dalam_keluarga' => 'required',
            'pendidikan' => 'required',
        ]);

        Warga::create($request->all());
        return redirect()->route('warga.index')->with('success', 'Warga berhasil ditambahkan');
    }

    public function edit(Warga $warga)
    {
        $keluargas = Keluarga::all();
        return view('warga.edit', compact('warga', 'keluargas'));
    }

    public function update(Request $request, Warga $warga)
    {
        $request->validate([
            'keluarga_id' => 'required',
            'nik' => 'required|unique:wargas,nik,' . $warga->id,
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'status_dalam_keluarga' => 'required',
            'pendidikan' => 'required',
        ]);

        $warga->update($request->all());
        return redirect()->route('warga.index')->with('success', 'Warga berhasil diupdate');
    }

    public function destroy(Warga $warga)
    {
        $warga->delete();
        return redirect()->route('warga.index')->with('success', 'Warga berhasil dihapus');
    }
}