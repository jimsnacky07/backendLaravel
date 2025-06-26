<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    public function index()
    {
        return response()->json(Penghuni::all());
    }

    public function show($id)
    {
        $penghuni = Penghuni::find($id);
        if (!$penghuni) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($penghuni);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            // tambahkan validasi field lain sesuai kebutuhan
        ]);
        $penghuni = Penghuni::create($data);
        return response()->json($penghuni, 201);
    }

    public function update(Request $request, $id)
    {
        $penghuni = Penghuni::find($id);
        if (!$penghuni) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $data = $request->all();
        $penghuni->update($data);
        return response()->json($penghuni);
    }

    public function destroy($id)
    {
        $penghuni = Penghuni::find($id);
        if (!$penghuni) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $penghuni->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
