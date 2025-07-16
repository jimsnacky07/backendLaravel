<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusKamar extends Model
{
    protected $table = 'status_kamar';
    protected $fillable = [
        'kamar_id',
        'status',
        'keterangan'
    ];

    // Relationships
    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id', 'id');
    }

    // Helper methods
    public function isAvailable()
    {
        return $this->status === 'Tersedia';
    }

    public function isOccupied()
    {
        return $this->status === 'Terisi';
    }

    public function isUnderMaintenance()
    {
        return $this->status === 'Maintenance';
    }
}
