<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $fillable = [
        'penghuni_id',
        'judul',
        'pesan',
        'tipe',
        'status',
        'dibaca_pada'
    ];

    // Relationships
    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class, 'penghuni_id', 'id');
    }

    // Helper methods
    public function isRead()
    {
        return $this->status === 'Sudah Dibaca';
    }

    public function isUnread()
    {
        return $this->status === 'Belum Dibaca';
    }

    public function markAsRead()
    {
        $this->update([
            'status' => 'Sudah Dibaca',
            'dibaca_pada' => now()
        ]);
    }

    public function getFormattedCreatedAt()
    {
        return $this->created_at->format('d/m/Y H:i');
    }
}
