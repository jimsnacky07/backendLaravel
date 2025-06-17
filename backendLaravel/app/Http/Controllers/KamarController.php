<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index(Request $request)
    {
        $query = Kamar::query();
        if ($request->has('q') && $request->q) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('id', 'like', "%$q%")
                    ->orWhere('lantai', 'like', "%$q%")
                    ->orWhere('kapasitas', 'like', "%$q%")
                    ->orWhere('fasilitas', 'like', "%$q%");
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
        ]);
        Kamar::create($validated);
        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kamar = Kamar::findOrFail($id);
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
        ]);
        $kamar->update($validated);
        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil diupdate');
    }

    public function destroy($id)
    {
        $kamar = Kamar::findOrFail($id);
        $kamar->delete();
        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil dihapus');
    }
}
