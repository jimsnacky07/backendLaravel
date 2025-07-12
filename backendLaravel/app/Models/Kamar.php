<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $table = 'kamar';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'lantai',
        'kapasitas',
        'fasilitas',
        'tarif',
        'max_penghuni'
    ];

    // Relationships
    public function penghuni()
    {
        return $this->hasMany(Penghuni::class, 'kamar', 'id');
    }

    public function statusKamar()
    {
        return $this->hasMany(StatusKamar::class, 'kamar_id', 'id');
    }

    public function fasilitasKamar()
    {
        return $this->hasMany(FasilitasKamar::class, 'kamar_id', 'id');
    }

    // Helper methods
    public function isOccupied()
    {
        return $this->penghuni()->exists();
    }

    public function getOccupancyStatus()
    {
        $currentOccupants = $this->penghuni()->count();
        $maxOccupants = $this->max_penghuni;

        if ($currentOccupants == 0) {
            return 'Kosong';
        } elseif ($currentOccupants < $maxOccupants) {
            return 'Tersedia (' . $currentOccupants . '/' . $maxOccupants . ')';
        } else {
            return 'Penuh (' . $currentOccupants . '/' . $maxOccupants . ')';
        }
    }

    public function getCurrentOccupantsCount()
    {
        return $this->penghuni()->count();
    }

    public function canAcceptNewOccupant()
    {
        return $this->getCurrentOccupantsCount() < $this->max_penghuni;
    }

    public function getAvailableSlots()
    {
        return $this->max_penghuni - $this->getCurrentOccupantsCount();
    }

    public function getCurrentStatus()
    {
        return $this->statusKamar()->latest()->first();
    }

    public function getFormattedTarif()
    {
        return 'Rp ' . number_format($this->tarif, 0, ',', '.');
    }

    public function getActiveFacilities()
    {
        return $this->fasilitasKamar()->where('status', 'Aktif')->get();
    }

    public function getOccupancyPercentage()
    {
        if ($this->max_penghuni == 0) return 0;
        return round(($this->getCurrentOccupantsCount() / $this->max_penghuni) * 100);
    }
}
