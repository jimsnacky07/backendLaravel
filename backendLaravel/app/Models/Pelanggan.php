<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
        'email',
        'created_at',
        'updated_at'
    ];

    // Define any relationships if necessary
    // public function orders() {
    //     return $this->hasMany(Order::class, 'pelanggan_id', 'id_pelanggan');
    // }
}