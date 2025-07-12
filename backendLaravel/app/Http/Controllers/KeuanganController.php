<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Penghuni;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Keuangan::with(['penghuni.kamar']);

        if ($request->has('q') && $request->q) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('id_penghuni', 'like', "%$q%")
                    ->orWhere('tgl_bayar', 'like', "%$q%")
                    ->orWhere('keterangan', 'like', "%$q%")
                    ->orWhere('id', 'like', "%$q%")
                    ->orWhereHas('penghuni', function ($subQuery) use ($q) {
                        $subQuery->where('nama', 'like', "%$q%");
                    });
            });
        }

        // Filter by penghuni
        if ($request->has('penghuni_id')) {
            $query->where('id_penghuni', $request->penghuni_id);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tgl_bayar', [$request->start_date, $request->end_date]);
        }

        $keuangans = $query->orderBy('tgl_bayar', 'desc')->paginate(10)->withQueryString();
        return view('keuangan.index', compact('keuangans'));
    }

    public function create()
    {
        $penghuni = Penghuni::with('kamar')->get();
        return view('keuangan.create', compact('penghuni'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string|max:10|unique:keuangan,id',
            'id_penghuni' => 'required|string|max:10|exists:penghuni,id',
            'tgl_bayar' => 'required|date',
            'bayar' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:20',
        ]);

        Keuangan::create($validated);
        return redirect()->route('keuangan.index')->with('success', 'Data keuangan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $keuangan = Keuangan::with(['penghuni.kamar'])->findOrFail($id);
        $penghuni = Penghuni::with('kamar')->get();
        return view('keuangan.edit', compact('keuangan', 'penghuni'));
    }

    public function update(Request $request, $id)
    {
        $keuangan = Keuangan::findOrFail($id);
        $validated = $request->validate([
            'id_penghuni' => 'required|string|max:10|exists:penghuni,id',
            'tgl_bayar' => 'required|date',
            'bayar' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:20',
        ]);

        $keuangan->update($validated);
        return redirect()->route('keuangan.index')->with('success', 'Data keuangan berhasil diupdate');
    }

    public function destroy($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        $keuangan->delete();
        return redirect()->route('keuangan.index')->with('success', 'Data keuangan berhasil dihapus');
    }

    public function show($id)
    {
        $keuangan = Keuangan::with(['penghuni.kamar'])->findOrFail($id);
        return view('keuangan.show', compact('keuangan'));
    }
}
