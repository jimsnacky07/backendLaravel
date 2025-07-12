<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        $kamars = Kamar::with(['penghuni', 'statusKamar'])->get();
        return response()->json([
            'success' => true,
            'data' => $kamars->map(function ($kamar) {
                return [
                    'id' => $kamar->id,
                    'lantai' => $kamar->lantai,
                    'kapasitas' => $kamar->kapasitas,
                    'fasilitas' => $kamar->fasilitas,
                    'tarif' => $kamar->tarif,
                    'max_penghuni' => $kamar->max_penghuni,
                    'status' => $kamar->getOccupancyStatus(),
                    'current_occupants' => $kamar->getCurrentOccupantsCount(),
                    'available_slots' => $kamar->getAvailableSlots(),
                    'penghuni' => $kamar->penghuni->map(function ($p) {
                        return ['id' => $p->id, 'nama' => $p->nama, 'nohp' => $p->nohp, 'registrasi' => $p->registrasi];
                    }),
                ];
            }),
            'message' => 'Data kamar berhasil diambil'
        ]);
    }

    public function show($id)
    {
        $kamar = Kamar::with(['penghuni', 'statusKamar', 'fasilitasKamar'])->find($id);

        if (!$kamar) {
            return response()->json([
                'success' => false,
                'message' => 'Kamar tidak ditemukan'
            ], 404);
        }

        // Add detailed occupancy information
        $kamar->occupancy_info = [
            'current_occupants' => $kamar->getCurrentOccupantsCount(),
            'max_occupants' => $kamar->max_penghuni,
            'available_slots' => $kamar->getAvailableSlots(),
            'occupancy_percentage' => $kamar->getOccupancyPercentage(),
            'status' => $kamar->getOccupancyStatus(),
            'can_accept_new_occupant' => $kamar->canAcceptNewOccupant(),
            'occupants_list' => $kamar->penghuni->map(function ($penghuni) {
                return [
                    'id' => $penghuni->id,
                    'nama' => $penghuni->nama,
                    'nohp' => $penghuni->nohp,
                    'registrasi' => $penghuni->registrasi
                ];
            })
        ];

        return response()->json([
            'success' => true,
            'data' => $kamar,
            'message' => 'Data kamar berhasil diambil'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|string|max:30|unique:kamar,id',
            'lantai' => 'required|integer',
            'kapasitas' => 'required|string|max:30',
            'fasilitas' => 'required|string|max:30',
            'tarif' => 'required|numeric',
            'max_penghuni' => 'required|integer|min:1|max:4',
        ]);

        $kamar = Kamar::create($data);

        return response()->json([
            'success' => true,
            'data' => $kamar,
            'message' => 'Kamar berhasil ditambahkan'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $kamar = Kamar::find($id);

        if (!$kamar) {
            return response()->json([
                'success' => false,
                'message' => 'Kamar tidak ditemukan'
            ], 404);
        }

        $data = $request->validate([
            'lantai' => 'sometimes|required|integer',
            'kapasitas' => 'sometimes|required|string|max:30',
            'fasilitas' => 'sometimes|required|string|max:30',
            'tarif' => 'sometimes|required|numeric',
            'max_penghuni' => 'sometimes|required|integer|min:1|max:4',
        ]);

        // Check if reducing max_penghuni would exceed current occupants
        if (isset($data['max_penghuni'])) {
            $currentOccupants = $kamar->getCurrentOccupantsCount();
            if ($data['max_penghuni'] < $currentOccupants) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat mengurangi kapasitas karena masih ada ' . $currentOccupants . ' penghuni'
                ], 400);
            }
        }

        $kamar->update($data);

        return response()->json([
            'success' => true,
            'data' => $kamar,
            'message' => 'Kamar berhasil diupdate'
        ]);
    }

    public function destroy($id)
    {
        $kamar = Kamar::find($id);

        if (!$kamar) {
            return response()->json([
                'success' => false,
                'message' => 'Kamar tidak ditemukan'
            ], 404);
        }

        // Check if room has occupants
        if ($kamar->penghuni()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Kamar tidak dapat dihapus karena masih ada penghuni'
            ], 400);
        }

        $kamar->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kamar berhasil dihapus'
        ]);
    }
}
