<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = [
        'user_id',
        'kategori',
        'subjek',
        'deskripsi',
        'lampiran',
        'status',
        'sentimen',
        'hasil_ai',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
