<?php

namespace App\Http\Controllers;

use App\Models\Penghuni;
use App\Models\Kamar;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    public function index(Request $request)
    {
        $query = Penghuni::with(['kamar', 'keuangan', 'tagihan']);

        if ($request->has('q') && $request->q) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nama', 'like', "%$q%")
                    ->orWhere('alamat', 'like', "%$q%")
                    ->orWhere('nohp', 'like', "%$q%")
                    ->orWhere('kamar', 'like', "%$q%")
                    ->orWhere('id', 'like', "%$q%");
            });
        }

        // Filter by room
        if ($request->has('kamar')) {
            $query->where('kamar', $request->kamar);
        }

        $penghunis = $query->orderBy('nama')->paginate(10)->withQueryString();
        return view('penghuni.index', compact('penghunis'));
    }

    public function create()
    {
        $kamars = Kamar::where('max_penghuni', '>', function ($query) {
            $query->selectRaw('COUNT(*)')
                ->from('penghuni')
                ->whereColumn('penghuni.kamar', 'kamar.id');
        })->get();

        return view('penghuni.create', compact('kamars'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string|max:30|unique:penghuni,id',
            'nama' => 'required|string|max:30',
            'alamat' => 'required|string|max:30',
            'nohp' => 'required|string|max:12',
            'registrasi' => 'required|date',
            'kamar' => 'required|string|max:30|exists:kamar,id',
        ]);

        // Check if room can accept new occupant
        $kamar = Kamar::find($validated['kamar']);
        if (!$kamar->canAcceptNewOccupant()) {
            return back()->withErrors(['kamar' => 'Kamar sudah penuh (maksimal ' . $kamar->max_penghuni . ' penghuni)'])->withInput();
        }

        Penghuni::create($validated);
        return redirect()->route('penghuni.index')->with('success', 'Penghuni berhasil ditambahkan');
    }

    public function edit($id)
    {
        $penghuni = Penghuni::with(['kamar'])->findOrFail($id);

        // Get available rooms (including current room)
        $kamars = Kamar::where(function ($query) use ($penghuni) {
            $query->where('max_penghuni', '>', function ($subQuery) {
                $subQuery->selectRaw('COUNT(*)')
                    ->from('penghuni')
                    ->whereColumn('penghuni.kamar', 'kamar.id');
            })
                ->orWhere('id', $penghuni->kamar); // Include current room
        })->get();

        return view('penghuni.edit', compact('penghuni', 'kamars'));
    }

    public function update(Request $request, $id)
    {
        $penghuni = Penghuni::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:30',
            'alamat' => 'required|string|max:30',
            'nohp' => 'required|string|max:12',
            'registrasi' => 'required|date',
            'kamar' => 'required|string|max:30|exists:kamar,id',
        ]);

        // Check if new room can accept occupant (if changed)
        if ($validated['kamar'] !== $penghuni->kamar) {
            $kamar = Kamar::find($validated['kamar']);
            if (!$kamar->canAcceptNewOccupant()) {
                return back()->withErrors(['kamar' => 'Kamar sudah penuh (maksimal ' . $kamar->max_penghuni . ' penghuni)'])->withInput();
            }
        }

        $penghuni->update($validated);
        return redirect()->route('penghuni.index')->with('success', 'Penghuni berhasil diupdate');
    }

    public function destroy($id)
    {
        $penghuni = Penghuni::with(['keuangan', 'tagihan'])->findOrFail($id);

        // Check if penghuni has financial records
        if ($penghuni->keuangan()->exists() || $penghuni->tagihan()->exists()) {
            return redirect()->route('penghuni.index')->with('error', 'Penghuni tidak dapat dihapus karena masih ada data keuangan');
        }

        $penghuni->delete();
        return redirect()->route('penghuni.index')->with('success', 'Penghuni berhasil dihapus');
    }

    public function show($id)
    {
        $penghuni = Penghuni::with(['kamar', 'keuangan', 'tagihan'])->findOrFail($id);
        return view('penghuni.show', compact('penghuni'));
    }
}
