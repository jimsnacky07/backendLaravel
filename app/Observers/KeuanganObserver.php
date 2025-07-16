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
            Log::info('DEBUG: Mulai proses update tagihan', ['id_penghuni' => $keuangan->id_penghuni, 'tgl_bayar' => $keuangan->tgl_bayar]);
            $bulan = $this->getBulanIndonesia($keuangan->tgl_bayar);
            $tahun = date('Y', strtotime($keuangan->tgl_bayar));
            $tagihan = Tagihan::where('id_penghuni', $keuangan->id_penghuni)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->first();
            if ($tagihan) {
                Log::info('DEBUG: Tagihan ditemukan dan akan diubah statusnya', ['tagihan_id' => $tagihan->id]);
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
            } else {
                Log::info('DEBUG: Tagihan tidak ditemukan untuk bulan dan tahun ini', ['id_penghuni' => $keuangan->id_penghuni, 'bulan' => $bulan, 'tahun' => $tahun]);
            }
            // Update tanggal_bayar penghuni ke bulan berikutnya
            $penghuni = \App\Models\Penghuni::find($keuangan->id_penghuni);
            if ($penghuni) {
                $kamarObj = is_object($penghuni->kamar) ? $penghuni->kamar->id : null;
                Log::info('DEBUG: Penghuni ditemukan', ['id_penghuni' => $penghuni->id, 'kamar_id' => $kamarObj]);
                $nextMonth = Carbon::parse($keuangan->tgl_bayar)->addMonthNoOverflow();
                $penghuni->tanggal_bayar = $nextMonth->toDateString();
                $penghuni->save();

                $kamar = $penghuni->kamarRelasi;
                if ($kamar instanceof \App\Models\Kamar) {
                    Log::info('DEBUG: Kamar ditemukan', ['kamar_id' => $kamar->id]);
                    $bulanBerikut = $this->getBulanIndonesia($nextMonth);
                    $tahunBerikut = $nextMonth->year;
                    $tanggalRegistrasi = Carbon::parse($penghuni->registrasi);
                    $tanggalTagihan = $tanggalRegistrasi->copy()->year($nextMonth->year)->month($nextMonth->month);
                    if ($tanggalTagihan->day > $tanggalTagihan->daysInMonth) {
                        $tanggalTagihan->day = $tanggalTagihan->daysInMonth;
                    }
                    Log::info('DEBUG: Update tagihan bulan berikutnya', [
                        'kamar_id' => $kamar->id,
                        'jumlah_penghuni' => $kamar->penghuni()->count(),
                        'tarif_kamar' => $kamar->tarif,
                        'bulan' => $bulanBerikut,
                        'tahun' => $tahunBerikut,
                        'tanggal_tagihan' => $tanggalTagihan->toDateString(),
                        'penghuni_ids' => $kamar->penghuni()->pluck('id')->toArray(),
                    ]);
                    $kamar->updateTagihanBulanBerikutnya($bulanBerikut, $tahunBerikut, $tanggalTagihan->toDateString());
                } else {
                    Log::warning('DEBUG: Kamar tidak ditemukan atau bukan objek Kamar', ['id_penghuni' => $penghuni->id, 'kamar_value' => $penghuni->kamar]);
                }
            } else {
                Log::info('DEBUG: Penghuni tidak ditemukan', ['id_penghuni' => $keuangan->id_penghuni]);
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
