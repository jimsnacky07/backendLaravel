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
        'keterangan'
    ];

    // Relationships
    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class, 'id_penghuni', 'id');
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
}
