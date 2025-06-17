<?php

namespace App\Http\Controllers;

use App\Models\Penghuni;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    public function index(Request $request)
    {
        $query = Penghuni::query();
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
        $penghunis = $query->orderBy('nama')->paginate(10)->withQueryString();
        return view('penghuni.index', compact('penghunis'));
    }

    public function create()
    {
        return view('penghuni.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string|max:30|unique:penghuni,id',
            'nama' => 'required|string|max:30',
            'alamat' => 'required|string|max:30',
            'nohp' => 'required|string|max:12',
            'registrasi' => 'required|date',
            'kamar' => 'required|string|max:30',
        ]);
        Penghuni::create($validated);
        return redirect()->route('penghuni.index')->with('success', 'Penghuni berhasil ditambahkan');
    }

    public function edit($id)
    {
        $penghuni = Penghuni::findOrFail($id);
        return view('penghuni.edit', compact('penghuni'));
    }

    public function update(Request $request, $id)
    {
        $penghuni = Penghuni::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:30',
            'alamat' => 'required|string|max:30',
            'nohp' => 'required|string|max:12',
            'registrasi' => 'required|date',
            'kamar' => 'required|string|max:30',
        ]);
        $penghuni->update($validated);
        return redirect()->route('penghuni.index')->with('success', 'Penghuni berhasil diupdate');
    }

    public function destroy($id)
    {
        $penghuni = Penghuni::findOrFail($id);
        $penghuni->delete();
        return redirect()->route('penghuni.index')->with('success', 'Penghuni berhasil dihapus');
    }

    public function show($id)
    {
        $penghuni = Penghuni::findOrFail($id);
        return view('penghuni.show', compact('penghuni'));
    }
}