<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        return response()->json(Kamar::all());
    }

    public function show($id)
    {
        $kamar = Kamar::find($id);
        if (!$kamar) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($kamar);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            // tambahkan validasi field lain sesuai kebutuhan
        ]);
        $kamar = Kamar::create($data);
        return response()->json($kamar, 201);
    }

    public function update(Request $request, $id)
    {
        $kamar = Kamar::find($id);
        if (!$kamar) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $data = $request->all();
        $kamar->update($data);
        return response()->json($kamar);
    }

    public function destroy($id)
    {
        $kamar = Kamar::find($id);
        if (!$kamar) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $kamar->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
