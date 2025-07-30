<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    protected $table = 'keuangan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'id_penghuni',
        'tgl_bayar',
        'bayar',
        'keterangan',
        'foto'
    ];

    // Relationships
    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class, 'id_penghuni', 'id');
    }

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'tagihan_id', 'id');
    }

    // Helper methods
    public function getFormattedAmount()
    {
        return 'Rp ' . number_format($this->bayar, 0, ',', '.');
    }

    public function getFormattedDate()
    {
        return date('d/m/Y', strtotime($this->tgl_bayar));
    }

    public function getFotoUrl()
    {
        if ($this->foto && !empty($this->foto)) {
            // Check if file actually exists
            $filePath = storage_path('app/public/' . $this->foto);
            if (file_exists($filePath)) {
                return asset('storage/' . $this->foto);
            }
            // If file doesn't exist, return null or a placeholder
            return null;
        }
        return null;
    }

    public function fotoExists()
    {
        if ($this->foto && !empty($this->foto)) {
            $filePath = storage_path('app/public/' . $this->foto);
            return file_exists($filePath);
        }
        return false;
    }
}
