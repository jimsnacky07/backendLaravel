<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\StatusKamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KamarController extends Controller
{
    public function index(Request $request)
    {
        $query = Kamar::with(['penghuni', 'statusKamar', 'fasilitasKamar']);

        if ($request->has('q') && $request->q) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('id', 'like', "%$q%")
                    ->orWhere('lantai', 'like', "%$q%")
                    ->orWhere('kapasitas', 'like', "%$q%")
                    ->orWhere('fasilitas', 'like', "%$q%");
            });
        }

        // Filter by status
        if ($request->has('status')) {
            $query->whereHas('statusKamar', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $kamars = $query->orderBy('id')->paginate(10)->withQueryString();
        return view('kamar.index', compact('kamars'));
    }

    public function create()
    {
        return view('kamar.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string|max:30|unique:kamar,id',
            'lantai' => 'required|integer',
            'kapasitas' => 'required|string|max:30',
            'fasilitas' => 'required|string|max:30',
            'tarif' => 'required|numeric',
            'max_penghuni' => 'required|integer|min:1|max:4',
        ]);

        DB::transaction(function () use ($validated) {
            $kamar = Kamar::create($validated);

            // Create default status
            StatusKamar::create([
                'kamar_id' => $kamar->id,
                'status' => 'Tersedia',
                'keterangan' => 'Kamar baru ditambahkan'
            ]);
        });

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kamar = Kamar::with(['penghuni', 'statusKamar'])->findOrFail($id);
        return view('kamar.edit', compact('kamar'));
    }

    public function update(Request $request, $id)
    {
        $kamar = Kamar::findOrFail($id);
        $validated = $request->validate([
            'lantai' => 'required|integer',
            'kapasitas' => 'required|string|max:30',
            'fasilitas' => 'required|string|max:30',
            'tarif' => 'required|numeric',
            'max_penghuni' => 'required|integer|min:1|max:4',
        ]);

        // Check if reducing max_penghuni would exceed current occupants
        $currentOccupants = $kamar->getCurrentOccupantsCount();
        if ($validated['max_penghuni'] < $currentOccupants) {
            return back()->withErrors(['max_penghuni' => 'Tidak dapat mengurangi kapasitas karena masih ada ' . $currentOccupants . ' penghuni'])->withInput();
        }

        $kamar->update($validated);
        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil diupdate');
    }

    public function destroy($id)
    {
        $kamar = Kamar::findOrFail($id);

        // Check if room has occupants
        if ($kamar->penghuni()->exists()) {
            return redirect()->route('kamar.index')->with('error', 'Kamar tidak dapat dihapus karena masih ada penghuni');
        }

        $kamar->delete();
        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil dihapus');
    }

    public function show($id)
    {
        $kamar = Kamar::with(['penghuni', 'statusKamar', 'fasilitasKamar'])->findOrFail($id);
        return view('kamar.show', compact('kamar'));
    }
}
