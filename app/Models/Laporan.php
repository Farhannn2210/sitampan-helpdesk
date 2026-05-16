<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'respon_admin',
        'respon_admin_sumber',
        'respon_admin_pada',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(LaporanMessage::class)->orderBy('created_at');
    }
}
