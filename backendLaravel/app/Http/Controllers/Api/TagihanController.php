<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    public function index()
    {
        return response()->json(Tagihan::all());
    }

    public function show($id)
    {
        $tagihan = Tagihan::find($id);
        if (!$tagihan) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($tagihan);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jumlah' => 'required|numeric',
            // tambahkan validasi field lain sesuai kebutuhan
        ]);
        $tagihan = Tagihan::create($data);
        return response()->json($tagihan, 201);
    }

    public function update(Request $request, $id)
    {
        $tagihan = Tagihan::find($id);
        if (!$tagihan) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $data = $request->all();
        $tagihan->update($data);
        return response()->json($tagihan);
    }

    public function destroy($id)
    {
        $tagihan = Tagihan::find($id);
        if (!$tagihan) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $tagihan->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
