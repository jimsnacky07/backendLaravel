<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Penghuni;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $query = Tagihan::with(['penghuni.kamar']);

        if ($request->has('q') && $request->q) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('id_penghuni', 'like', "%$q%")
                    ->orWhere('bulan', 'like', "%$q%")
                    ->orWhere('tahun', 'like', "%$q%")
                    ->orWhere('status', 'like', "%$q%")
                    ->orWhere('id', 'like', "%$q%")
                    ->orWhereHas('penghuni', function ($subQuery) use ($q) {
                        $subQuery->where('nama', 'like', "%$q%");
                    });
            });
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by penghuni
        if ($request->has('penghuni_id')) {
            $query->where('id_penghuni', $request->penghuni_id);
        }

        // Filter by month/year
        if ($request->has('bulan') && $request->has('tahun')) {
            $query->where('bulan', $request->bulan)
                ->where('tahun', $request->tahun);
        }

        $tagihans = $query->orderBy('tanggal', 'desc')->paginate(10)->withQueryString();
        return view('tagihan.index', compact('tagihans'));
    }

    public function create()
    {
        $penghuni = Penghuni::with('kamar')->get();
        return view('tagihan.create', compact('penghuni'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_penghuni' => 'required|string|max:30|exists:penghuni,id',
            'bulan' => 'required|string|max:20',
            'tahun' => 'required|string|max:4',
            'tagihan' => 'required|numeric|min:0',
            'status' => 'required|in:Lunas,Belum Lunas',
            'tanggal' => 'required|date',
        ]);

        // Check for duplicate tagihan
        $existingTagihan = Tagihan::where('id_penghuni', $validated['id_penghuni'])
            ->where('bulan', $validated['bulan'])
            ->where('tahun', $validated['tahun'])
            ->exists();

        if ($existingTagihan) {
            return back()->withErrors(['bulan' => 'Tagihan untuk bulan dan tahun ini sudah ada'])->withInput();
        }

        Tagihan::create($validated);
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $tagihan = Tagihan::with(['penghuni.kamar'])->findOrFail($id);
        $penghuni = Penghuni::with('kamar')->get();
        return view('tagihan.edit', compact('tagihan', 'penghuni'));
    }

    public function update(Request $request, $id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $validated = $request->validate([
            'id_penghuni' => 'required|string|max:30|exists:penghuni,id',
            'bulan' => 'required|string|max:20',
            'tahun' => 'required|string|max:4',
            'tagihan' => 'required|numeric|min:0',
            'status' => 'required|in:Lunas,Belum Lunas',
            'tanggal' => 'required|date',
        ]);

        // Check for duplicate tagihan (excluding current record)
        $existingTagihan = Tagihan::where('id_penghuni', $validated['id_penghuni'])
            ->where('bulan', $validated['bulan'])
            ->where('tahun', $validated['tahun'])
            ->where('id', '!=', $id)
            ->exists();

        if ($existingTagihan) {
            return back()->withErrors(['bulan' => 'Tagihan untuk bulan dan tahun ini sudah ada'])->withInput();
        }

        $tagihan->update($validated);
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil diupdate');
    }

    public function destroy($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->delete();
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dihapus');
    }

    public function show($id)
    {
        $tagihan = Tagihan::with(['penghuni.kamar'])->findOrFail($id);
        return view('tagihan.show', compact('tagihan'));
    }
}
