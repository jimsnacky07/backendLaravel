<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Penghuni;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $query = Tagihan::query();
        if ($request->has('q') && $request->q) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('id_penghuni', 'like', "%$q%")
                    ->orWhere('bulan', 'like', "%$q%")
                    ->orWhere('tahun', 'like', "%$q%")
                    ->orWhere('status', 'like', "%$q%")
                    ->orWhere('id', 'like', "%$q%");
            });
        }
        $tagihans = $query->orderBy('tanggal', 'desc')->paginate(10)->withQueryString();
        return view('tagihan.index', compact('tagihans'));
    }

    public function create()
    {
        $penghuni = Penghuni::all();
        return view('tagihan.create', compact('penghuni'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_penghuni' => 'required|string|max:30|exists:penghuni,id',
            'bulan' => 'required|string|max:20',
            'tahun' => 'required|string|max:4',
            'tagihan' => 'required|numeric',
            'status' => 'required|in:Lunas,Belum Lunas',
            'tanggal' => 'required|date',
        ]);
        Tagihan::create($validated);
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $penghuni = Penghuni::all();
        return view('tagihan.edit', compact('tagihan', 'penghuni'));
    }

    public function update(Request $request, $id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $validated = $request->validate([
            'id_penghuni' => 'required|string|max:30|exists:penghuni,id',
            'bulan' => 'required|string|max:20',
            'tahun' => 'required|string|max:4',
            'tagihan' => 'required|numeric',
            'status' => 'required|in:Lunas,Belum Lunas',
            'tanggal' => 'required|date',
        ]);
        $tagihan->update($validated);
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil diupdate');
    }

    public function destroy($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->delete();
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dihapus');
    }
}
