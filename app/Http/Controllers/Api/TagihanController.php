<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;

class TagihanController extends Controller
{
    // Ambil semua tagihan
    public function index()
    {
        return response()->json(Tagihan::all());
    }

    // Ambil detail tagihan berdasarkan ID
    public function show($id)
    {
        $tagihan = Tagihan::find($id);
        if (!$tagihan) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($tagihan);
    }

    // Simpan tagihan baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'jumlah' => 'required|numeric',
            // Tambahkan validasi field lain sesuai kebutuhan
        ]);

        $tagihan = Tagihan::create($data);
        return response()->json($tagihan, 201);
    }

    // Update tagihan berdasarkan ID
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

    // Hapus tagihan berdasarkan ID
    public function destroy($id)
    {
        $tagihan = Tagihan::find($id);
        if (!$tagihan) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $tagihan->delete();
        return response()->json(['message' => 'Deleted']);
    }

    // Edit data pembayaran tagihan
    public function editTagihan(Request $request, $user_id)
    {
        $request->validate([
            'tagihan_id' => 'required|integer|exists:tagihans,id',
            'status' => 'required|string',
            'jumlah_bayar' => 'required|integer',
            'tanggal_bayar' => 'required|date',
            'metode_pembayaran' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $tagihan = Tagihan::where('id', $request->tagihan_id)
            ->where('user_id', $user_id)
            ->first();

        if (!$tagihan) {
            return response()->json(['message' => 'Tagihan tidak ditemukan'], 404);
        }

        $tagihan->status = $request->status;
        $tagihan->jumlah_bayar = $request->jumlah_bayar;
        $tagihan->tanggal_bayar = $request->tanggal_bayar;
        $tagihan->metode_pembayaran = $request->metode_pembayaran;
        $tagihan->keterangan = $request->keterangan;
        $tagihan->save();

        return response()->json(['message' => 'Pembayaran berhasil', 'tagihan' => $tagihan]);
    }
}
