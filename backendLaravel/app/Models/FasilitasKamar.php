<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FasilitasKamar extends Model
{
    protected $table = 'fasilitas_kamar';
    protected $fillable = [
        'kamar_id',
        'nama_fasilitas',
        'deskripsi',
        'status'
    ];

    // Relationships
    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id', 'id');
    }

    // Helper methods
    public function isActive()
    {
        return $this->status === 'Aktif';
    }

    public function isDamaged()
    {
        return $this->status === 'Rusak';
    }

    public function isUnderMaintenance()
    {
        return $this->status === 'Maintenance';
    }
}
