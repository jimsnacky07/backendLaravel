<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KeuanganController extends Controller
{
    // Untuk API: pastikan route memakai middleware auth:sanctum atau auth:api

    public function index(Request $request)
    {
        $query = Keuangan::with(['penghuni.kamar']);

        // Optional: filter by search
        if ($request->has('q') && $request->q) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('keterangan', 'like', "%$q%")
                    ->orWhere('id', 'like', "%$q%");
            });
        }

        // Optional: filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tgl_bayar', [$request->start_date, $request->end_date]);
        }

        $keuangans = $query->orderBy('tgl_bayar', 'desc')->paginate(10);

        return view('keuangan.index', compact('keuangans'));
    }

    public function create()
    {
        $penghuniList = Penghuni::all();
        return view('keuangan.create', compact('penghuniList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_penghuni' => 'required|string|max:30',
            'tgl_bayar' => 'required|date',
            'bayar' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $data = $request->only(['id_penghuni', 'tgl_bayar', 'bayar', 'keterangan']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_keuangan', 'public');
        }

        $keuangan = Keuangan::create($data);

        return redirect()->route('keuangan.index')->with('success', 'Data keuangan berhasil ditambahkan');
    }

    public function show($id)
    {
        $keuangan = Keuangan::with(['penghuni.kamar'])->findOrFail($id);
        return view('keuangan.show', compact('keuangan'));
    }

    public function edit($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        $penghuniList = Penghuni::all();
        return view('keuangan.edit', compact('keuangan', 'penghuniList'));
    }

    public function update(Request $request, $id)
    {
        $keuangan = Keuangan::findOrFail($id);

        $request->validate([
            'id_penghuni' => 'required|string|max:30',
            'tgl_bayar' => 'required|date',
            'bayar' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $data = $request->only(['id_penghuni', 'tgl_bayar', 'bayar', 'keterangan']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($keuangan->foto) {
                Storage::disk('public')->delete($keuangan->foto);
            }
            
            $data['foto'] = $request->file('foto')->store('foto_keuangan', 'public');
        }

        $keuangan->update($data);

        return redirect()->route('keuangan.index')->with('success', 'Data keuangan berhasil diupdate');
    }

    public function destroy($id)
    {
        $keuangan = Keuangan::findOrFail($id);

        // Hapus foto jika ada
        if ($keuangan->foto) {
            Storage::disk('public')->delete($keuangan->foto);
        }

        $keuangan->delete();

        return redirect()->route('keuangan.index')->with('success', 'Data keuangan berhasil dihapus');
    }
}