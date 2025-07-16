<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    public function index()
    {
        $penghuni = Penghuni::with(['kamar', 'keuangan', 'tagihan'])->get();
        return response()->json([
            'success' => true,
            'data' => $penghuni->map(function ($p) {
                return [
                    'id' => $p->id,
                    'nama' => $p->nama,
                    'alamat' => $p->alamat,
                    'nohp' => $p->nohp,
                    'registrasi' => $p->registrasi,
                    'kamar' => $p->kamar ? [
                        'id' => $p->kamar->id,
                        'status' => $p->kamar->getOccupancyStatus(),
                        'max_penghuni' => $p->kamar->max_penghuni,
                        'current_occupants' => $p->kamar->getCurrentOccupantsCount(),
                        'available_slots' => $p->kamar->getAvailableSlots(),
                    ] : null,
                    'roommates' => $p->getRoommates()->pluck('nama'),
                    'keuangan' => $p->keuangan,
                    'tagihan' => $p->tagihan,
                ];
            }),
            'message' => 'Data penghuni berhasil diambil'
        ]);
    }

    public function show($id)
    {
        $penghuni = Penghuni::with(['kamar', 'keuangan', 'tagihan'])->find($id);

        if (!$penghuni) {
            return response()->json([
                'success' => false,
                'message' => 'Penghuni tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $penghuni,
            'message' => 'Data penghuni berhasil diambil'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|string|max:30|unique:penghuni,id',
            'nama' => 'required|string|max:30',
            'alamat' => 'required|string|max:30',
            'nohp' => 'required|string|max:12',
            'registrasi' => 'required|date',
            'kamar' => 'required|string|max:30|exists:kamar,id',
        ]);

        // Check if room can accept new occupant
        $kamar = \App\Models\Kamar::find($data['kamar']);
        if (!$kamar->canAcceptNewOccupant()) {
            return response()->json([
                'success' => false,
                'message' => 'Kamar sudah penuh (maksimal ' . $kamar->max_penghuni . ' penghuni)'
            ], 400);
        }

        $penghuni = Penghuni::create($data);

        return response()->json([
            'success' => true,
            'data' => $penghuni->load(['kamar']),
            'message' => 'Penghuni berhasil ditambahkan'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $penghuni = Penghuni::find($id);

        if (!$penghuni) {
            return response()->json([
                'success' => false,
                'message' => 'Penghuni tidak ditemukan'
            ], 404);
        }

        $data = $request->validate([
            'nama' => 'sometimes|required|string|max:30',
            'alamat' => 'sometimes|required|string|max:30',
            'nohp' => 'sometimes|required|string|max:12',
            'registrasi' => 'sometimes|required|date',
            'kamar' => 'sometimes|required|string|max:30|exists:kamar,id',
        ]);

        // Check if new room can accept occupant (if changed)
        if (isset($data['kamar']) && $data['kamar'] !== $penghuni->kamar) {
            $kamar = \App\Models\Kamar::find($data['kamar']);
            if (!$kamar->canAcceptNewOccupant()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kamar sudah penuh (maksimal ' . $kamar->max_penghuni . ' penghuni)'
                ], 400);
            }
        }

        $penghuni->update($data);

        return response()->json([
            'success' => true,
            'data' => $penghuni->load(['kamar']),
            'message' => 'Penghuni berhasil diupdate'
        ]);
    }

    public function destroy($id)
    {
        $penghuni = Penghuni::with(['keuangan', 'tagihan'])->find($id);

        if (!$penghuni) {
            return response()->json([
                'success' => false,
                'message' => 'Penghuni tidak ditemukan'
            ], 404);
        }

        // Check if penghuni has financial records
        if ($penghuni->keuangan()->exists() || $penghuni->tagihan()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Penghuni tidak dapat dihapus karena masih ada data keuangan'
            ], 400);
        }

        $penghuni->delete();

        return response()->json([
            'success' => true,
            'message' => 'Penghuni berhasil dihapus'
        ]);
    }
}
