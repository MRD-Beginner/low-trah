<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partner extends Model
{
    use HasFactory;

    protected $table = 'pasangan';

    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'urutan_anak',
        'status_kehidupan',
        'anggota_keluarga_id', // FK ke anggota_keluarga
        'photo',
    ];

    // Relasi balik ke AnggotaKeluarga
    public function anggotaKeluarga()
    {
        return $this->belongsTo(AnggotaKeluarga::class, 'anggota_keluarga_id');
    }
}
