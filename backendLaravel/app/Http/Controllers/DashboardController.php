<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Tagihan;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $kamar = Kamar::count();
        $penghuni = Penghuni::count();
        $tagihan = Tagihan::count();
        $admin = Admin::count();
        $penghuni_terbaru = Penghuni::orderBy('registrasi', 'desc')->take(5)->get();
        // Grafik: jumlah tagihan per bulan (12 bulan terakhir)
        $tagihan_per_bulan = Tagihan::selectRaw('YEAR(tanggal) as tahun, MONTH(tanggal) as bulan, COUNT(*) as total')
            ->whereYear('tanggal', date('Y'))
            ->groupBy(DB::raw('YEAR(tanggal)'), DB::raw('MONTH(tanggal)'))
            ->orderBy('bulan')
            ->get();
        $bulan = [];
        $total_tagihan = [];
        foreach ($tagihan_per_bulan as $row) {
            $bulan[] = date('M', mktime(0, 0, 0, $row->bulan, 10));
            $total_tagihan[] = $row->total;
        }
        return view('dashboard', compact('kamar', 'penghuni', 'tagihan', 'admin', 'penghuni_terbaru', 'bulan', 'total_tagihan'));
    }
}
