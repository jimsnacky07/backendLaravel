<?php

namespace App\Observers;

use App\Models\Keuangan;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class KeuanganObserver
{
    /**
     * Handle the Keuangan "created" event.
     *
     * @param  \App\Models\Keuangan  $keuangan
     * @return void
     */
    public function created(Keuangan $keuangan)
    {
        if ($keuangan->id_penghuni && $keuangan->tgl_bayar) {
            $bulan = $this->getBulanIndonesia($keuangan->tgl_bayar);
            $tahun = date('Y', strtotime($keuangan->tgl_bayar));
            $tagihan = Tagihan::where('id_penghuni', $keuangan->id_penghuni)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->first();
            if ($tagihan) {
                $tagihan->status = 'Lunas';
                $tagihan->save();
                $keuangan->keterangan = 'Tagihan Lunas';
                $keuangan->save();
                Log::info('Status tagihan diubah menjadi Lunas', [
                    'tagihan_id' => $tagihan->id,
                    'id_penghuni' => $tagihan->id_penghuni,
                    'bulan' => $tagihan->bulan,
                    'tahun' => $tagihan->tahun,
                    'waktu' => Carbon::now(),
                ]);
            }
        }
    }

    /**
     * Handle the Keuangan "updated" event.
     *
     * @param  \App\Models\Keuangan  $keuangan
     * @return void
     */
    public function updated(Keuangan $keuangan)
    {
        if ($keuangan->keterangan === 'Sudah Bayar!') {
            $bulan = $this->getBulanIndonesia($keuangan->tgl_bayar);
            $tahun = date('Y', strtotime($keuangan->tgl_bayar));
            $tagihan = Tagihan::where('id_penghuni', $keuangan->id_penghuni)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->first();
            if ($tagihan && $tagihan->status !== 'Lunas') {
                $tagihan->status = 'Lunas';
                $tagihan->save();
                Log::info('Status tagihan diubah menjadi Lunas via update keuangan', [
                    'tagihan_id' => $tagihan->id,
                    'id_penghuni' => $tagihan->id_penghuni,
                    'bulan' => $tagihan->bulan,
                    'tahun' => $tagihan->tahun,
                    'waktu' => Carbon::now(),
                ]);
            }
        }
    }

    private function getBulanIndonesia($date)
    {
        $bulanInggris = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        ];
        $bulan = date('F', strtotime($date));
        return $bulanInggris[$bulan] ?? $bulan;
    }
}
