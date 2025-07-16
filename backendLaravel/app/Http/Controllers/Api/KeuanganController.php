<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index()
    {
        return response()->json(Keuangan::all());
    }

    public function show($id)
    {
        $keuangan = Keuangan::find($id);
        if (!$keuangan) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($keuangan);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jumlah' => 'required|numeric',
            // tambahkan validasi field lain sesuai kebutuhan
        ]);
        $keuangan = Keuangan::create($data);
        return response()->json($keuangan, 201);
    }

    public function update(Request $request, $id)
    {
        $keuangan = Keuangan::find($id);
        if (!$keuangan) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $data = $request->all();
        $keuangan->update($data);
        return response()->json($keuangan);
    }

    public function destroy($id)
    {
        $keuangan = Keuangan::find($id);
        if (!$keuangan) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $keuangan->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
