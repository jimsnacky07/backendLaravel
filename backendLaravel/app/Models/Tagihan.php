<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihan';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id_penghuni',
        'bulan',
        'tahun',
        'tagihan',
        'status',
        'tanggal'
    ];

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class, 'id_penghuni', 'id');
    }
}
