<?php

namespace App\Http\Controllers;

use App\Models\JenisIuran;
use Illuminate\Http\Request;

class JenisIuranController extends Controller
{
    public function index()
    {
        $jenisIurans = JenisIuran::all();
        return view('jenis-iuran.index', compact('jenisIurans'));
    }

    public function create()
    {
        return view('jenis-iuran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nominal' => 'required|numeric',
            'periode' => 'required'
        ]);

        JenisIuran::create($request->all());
        return redirect()->route('jenis-iuran.index')->with('success', 'Jenis iuran berhasil ditambahkan');
    }

    public function edit(JenisIuran $jenisIuran)
    {
        return view('jenis-iuran.edit', compact('jenisIuran'));
    }

    public function update(Request $request, JenisIuran $jenisIuran)
    {
        $request->validate([
            'nama' => 'required',
            'nominal' => 'required|numeric',
            'periode' => 'required'
        ]);

        $jenisIuran->update($request->all());
        return redirect()->route('jenis-iuran.index')->with('success', 'Jenis iuran berhasil diupdate');
    }

    public function destroy(JenisIuran $jenisIuran)
    {
        $jenisIuran->delete();
        return redirect()->route('jenis-iuran.index')->with('success', 'Jenis iuran berhasil dihapus');
    }
}