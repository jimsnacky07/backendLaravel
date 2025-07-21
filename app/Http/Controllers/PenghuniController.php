<?php

namespace App\Http\Controllers;

use App\Models\Penghuni;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenghuniController extends Controller
{
    public function index(Request $request)
    {
        $query = Penghuni::with(['kamar', 'keuangan', 'tagihan']);

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

        // Filter by room
        if ($request->has('kamar')) {
            $query->where('kamar', $request->kamar);
        }

        $penghunis = $query->orderBy('nama')->paginate(10)->withQueryString();
        return view('penghuni.index', compact('penghunis'));
    }

    public function create()
    {
        $kamars = Kamar::where('max_penghuni', '>', function ($query) {
            $query->selectRaw('COUNT(*)')
                ->from('penghuni')
                ->whereColumn('penghuni.kamar', 'kamar.id');
        })->get();

        return view('penghuni.create', compact('kamars'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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
            $fotoPath = $request->file('foto')->store('foto', 'public');
            $validated['foto'] = $fotoPath;
        }

        // Check if room can accept new occupant
        $kamar = Kamar::find($validated['kamar']);
        if (!$kamar->canAcceptNewOccupant()) {
            return back()->withErrors(['kamar' => 'Kamar sudah penuh (maksimal ' . $kamar->max_penghuni . ' penghuni)'])->withInput();
        }

        $penghuni = Penghuni::create($validated);

        // Tambahkan logika otomatis buat tagihan untuk penghuni baru
        $penghuniBaru = Penghuni::where('id', $validated['id'])->first();
        if ($penghuniBaru) {
            $kamar = $penghuniBaru->kamarRelasi;
            if ($kamar) {
                $tanggalBayar = $penghuniBaru->tanggal_bayar;
                $bulan = \App\Models\Kamar::getBulanIndonesia($tanggalBayar);
                $tahun = date('Y', strtotime($tanggalBayar));
                $jumlahPenghuni = $kamar->penghuni()->count();
                $tarifPerPenghuni = $jumlahPenghuni > 0 ? $kamar->tarif / $jumlahPenghuni : $kamar->tarif;
                // Cek apakah tagihan sudah ada
                $tagihanAda = $penghuniBaru->tagihan()->where('bulan', $bulan)->where('tahun', $tahun)->exists();
                if (!$tagihanAda) {
                    \App\Models\Tagihan::create([
                        'id_penghuni' => $penghuniBaru->id,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                        'tagihan' => round($tarifPerPenghuni),
                        'status' => 'Belum Lunas',
                        'tanggal' => $tanggalBayar,
                    ]);
                }
            }
        }
        return redirect()->route('penghuni.index')->with('success', 'Penghuni berhasil ditambahkan');
    }

    public function edit($id)
    {
        $penghuni = Penghuni::with(['kamar'])->findOrFail($id);

        // Get available rooms (including current room)
        $kamars = Kamar::where(function ($query) use ($penghuni) {
            $query->where('max_penghuni', '>', function ($subQuery) {
                $subQuery->selectRaw('COUNT(*)')
                    ->from('penghuni')
                    ->whereColumn('penghuni.kamar', 'kamar.id');
            })
                ->orWhere('id', $penghuni->kamar); // Include current room
        })->get();

        return view('penghuni.edit', compact('penghuni', 'kamars'));
    }

    public function update(Request $request, $id)
    {
        $penghuni = Penghuni::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:30',
            'alamat' => 'required|string|max:30',
            'nohp' => 'required|string|max:12',
            'registrasi' => 'required|date',
            'tanggal_bayar' => 'required|date',
            'kamar' => 'required|string|max:30|exists:kamar,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,svg',
        ]);
        if ($request->hasFile('foto')) {
            if ($penghuni->foto) {
                Storage::disk('public')->delete($penghuni->foto);
            }
            $fotoPath = $request->file('foto')->store('foto', 'public');
            $validated['foto'] = $fotoPath;
        }

        // Check if new room can accept occupant (if changed)
        if ($validated['kamar'] !== $penghuni->kamar) {
            $kamar = Kamar::find($validated['kamar']);
            if (!$kamar->canAcceptNewOccupant()) {
                return back()->withErrors(['kamar' => 'Kamar sudah penuh (maksimal ' . $kamar->max_penghuni . ' penghuni)'])->withInput();
            }
        }

        $penghuni->update($validated);
        return redirect()->route('penghuni.index')->with('success', 'Penghuni berhasil diupdate');
    }

    public function destroy($id)
    {
        $penghuni = Penghuni::with(['keuangan', 'tagihan', 'kamar'])->findOrFail($id);

        // Check if penghuni has financial records
        if ($penghuni->keuangan()->exists() || $penghuni->tagihan()->exists()) {
            return redirect()->route('penghuni.index')->with('error', 'Penghuni tidak dapat dihapus karena masih ada data keuangan');
        }

        $kamar = $penghuni->kamar;
        if ($kamar && !$kamar instanceof \App\Models\Kamar) {
            $kamar = \App\Models\Kamar::find($kamar);
        }
        $penghuni->delete();

        // Update tagihan bulan berikutnya untuk semua penghuni kamar setelah ada yang keluar
        if ($kamar instanceof \App\Models\Kamar) {
            $now = now();
            $bulanBerikut = \App\Models\Kamar::getBulanIndonesia($now);
            $tahunBerikut = $now->year;
            $tanggalTagihan = $now->toDateString();
            $kamar->updateTagihanBulanBerikutnya($bulanBerikut, $tahunBerikut, $tanggalTagihan);
        }

        return redirect()->route('penghuni.index')->with('success', 'Penghuni berhasil dihapus');
    }

    public function show($id)
    {
        $penghuni = Penghuni::with(['kamar', 'keuangan', 'tagihan'])->findOrFail($id);
        return view('penghuni.show', compact('penghuni'));
    }
}
