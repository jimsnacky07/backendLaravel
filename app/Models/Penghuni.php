<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    protected $table = 'penghuni';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'nama',
        'alamat',
        'nohp',
        'registrasi',
        'kamar',
        'tanggal_bayar',
        'kamar',
        'user_id',
    ];

    // Relationships
    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar', 'id');
    }

    public function kamarRelasi()
    {
        return $this->belongsTo(Kamar::class, 'kamar', 'id');
    }

    public function keuangan()
    {
        return $this->hasMany(Keuangan::class, 'id_penghuni', 'id');
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'id_penghuni', 'id');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'penghuni_id', 'id');
    }

    /**
     * Relasi ke model User (one-to-one)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Helper methods
    public function getTotalPayments()
    {
        return $this->keuangan()->sum('bayar');
    }

    public function getOutstandingBills()
    {
        return $this->tagihan()->where('status', 'Belum Lunas')->sum('tagihan');
    }

    public function getPaymentHistory()
    {
        return $this->keuangan()->orderBy('tgl_bayar', 'desc')->get();
    }

    public function getUnpaidBills()
    {
        return $this->tagihan()->where('status', 'Belum Lunas')->get();
    }

    public function getUnreadNotifications()
    {
        return $this->notifikasi()->where('status', 'Belum Dibaca')->get();
    }

    public function getFormattedRegistrasi()
    {
        return date('d/m/Y', strtotime($this->registrasi));
    }

    public function getFormattedNohp()
    {
        return '+62' . substr($this->nohp, 1);
    }

    public function getFormattedTanggalBayar()
    {
        if (!$this->tanggal_bayar) {
            return '-';
        }
        return date('d/m/Y', strtotime($this->tanggal_bayar));
    }

    public function getDurationOfStay()
    {
        if (!$this->registrasi) {
            return 0;
        }
        $registrasi = \Carbon\Carbon::parse($this->registrasi);
        $now = \Carbon\Carbon::now();
        return $registrasi->diffInDays($now);
    }

    public function getMonthlyPayment()
    {
        return is_object($this->kamar) ? $this->kamar->tarif : 0;
    }

    // Roommate methods
    public function getRoommates()
    {
        if (!is_object($this->kamar) || !$this->kamar) {
            return collect();
        }

        return $this->kamar->penghuni()
            ->where('id', '!=', $this->id)
            ->get();
    }

    public function hasRoommates()
    {
        return $this->getRoommates()->count() > 0;
    }

    public function getRoommateCount()
    {
        return $this->getRoommates()->count();
    }

    public function isRoomFull()
    {
        if (!is_object($this->kamar) || !$this->kamar) {
            return false;
        }

        return $this->kamar->getCurrentOccupantsCount() >= $this->kamar->max_penghuni;
    }

    public function getRoomOccupancyInfo()
    {
        if (!is_object($this->kamar) || !$this->kamar) {
            return null;
        }

        return [
            'current_occupants' => $this->kamar->getCurrentOccupantsCount(),
            'max_occupants' => $this->kamar->max_penghuni,
            'available_slots' => $this->kamar->getAvailableSlots(),
            'roommates' => $this->getRoommates()->pluck('nama')->toArray()
        ];
    }
}
