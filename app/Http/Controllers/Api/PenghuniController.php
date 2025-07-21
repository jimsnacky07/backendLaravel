<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenghuniController extends Controller
{
    public function index()
    {
        $penghuni = Penghuni::with(['kamar', 'keuangan', 'tagihan'])->get();
        $penghuni = $penghuni->map(function ($p) {
            $p->foto = $p->foto ? asset('storage/' . $p->foto) : null;
            if (is_object($p->kamar)) {
                $p->kamar = [
                    'id' => $p->kamar->id,
                    'status' => $p->kamar->getOccupancyStatus(),
                    'max_penghuni' => $p->kamar->max_penghuni,
                    'current_occupants' => $p->kamar->getCurrentOccupantsCount(),
                    'available_slots' => $p->kamar->getAvailableSlots(),
                ];
            } else {
                $p->kamar = null;
            }
            $p->keuangan = \Illuminate\Support\Collection::make($p->keuangan)->map(function ($k) {
                return [
                    'id' => $k->id,
                    'tanggal_bayar' => $k->tgl_bayar,
                    'jumlah_bayar' => $k->bayar,
                ];
            })->values();
            $p->tagihan = \Illuminate\Support\Collection::make($p->tagihan)->map(function ($t) {
                return [
                    'id' => $t->id,
                    'tanggal_tagihan' => $t->tanggal,
                    'jumlah_tagihan' => $t->tagihan,
                ];
            })->values();
            return $p;
        });
        return response()->json($penghuni);
    }

    public function show($id)
    {
        $penghuni = Penghuni::with(['kamar', 'keuangan', 'tagihan'])->find($id);
        if (!$penghuni) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $penghuni->foto = $penghuni->foto ? asset('storage/' . $penghuni->foto) : null;
        if (is_object($penghuni->kamar)) {
            $penghuni->kamar = [
                'id' => $penghuni->kamar->id,
                'status' => $penghuni->kamar->getOccupancyStatus(),
                'max_penghuni' => $penghuni->kamar->max_penghuni,
                'current_occupants' => $penghuni->kamar->getCurrentOccupantsCount(),
                'available_slots' => $penghuni->kamar->getAvailableSlots(),
            ];
        } else {
            $penghuni->kamar = null;
        }
        $penghuni->keuangan = \Illuminate\Support\Collection::make($penghuni->keuangan)->map(function ($k) {
            return [
                'id' => $k->id,
                'tanggal_bayar' => $k->tgl_bayar,
                'jumlah_bayar' => $k->bayar,
            ];
        })->values();
        $penghuni->tagihan = \Illuminate\Support\Collection::make($penghuni->tagihan)->map(function ($t) {
            return [
                'id' => $t->id,
                'tanggal_tagihan' => $t->tanggal,
                'jumlah_tagihan' => $t->tagihan,
            ];
        })->values();
        return response()->json($penghuni);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|string|max:30|unique:penghuni,id',
            'nama' => 'required|string|max:30',
            'alamat' => 'required|string|max:30',
            'nohp' => 'required|string|max:12',
            'registrasi' => 'required|date',
            'tanggal_bayar' => 'required|date',
            'kamar' => 'required|string|max:30|exists:kamar,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,svg',
        ]);
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_penghuni', 'public');
            $data['foto'] = $fotoPath;
        }

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
            'tanggal_bayar' => 'sometimes|required|date',
            'kamar' => 'sometimes|required|string|max:30|exists:kamar,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,svg',
        ]);
        if ($request->hasFile('foto')) {
            if ($penghuni->foto) {
                Storage::disk('public')->delete($penghuni->foto);
            }
            $fotoPath = $request->file('foto')->store('foto_penghuni', 'public');
            $data['foto'] = $fotoPath;
        }

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
