<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        return response()->json(Pelanggan::all());
    }

    public function show($id)
    {
        $pelanggan = Pelanggan::find($id);
        if (!$pelanggan) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($pelanggan);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            // tambahkan validasi field lain sesuai kebutuhan
        ]);
        $pelanggan = Pelanggan::create($data);
        return response()->json($pelanggan, 201);
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::find($id);
        if (!$pelanggan) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $data = $request->all();
        $pelanggan->update($data);
        return response()->json($pelanggan);
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::find($id);
        if (!$pelanggan) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $pelanggan->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
