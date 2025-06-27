<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Anggota_Keluarga;

class Trah extends Model
{
    use HasFactory;
    protected $table = 'trah';
    protected $fillable = [
        'id',
        'trah_name',
        'description',
        'created_by',
        'visibility',
        'password',
    ];
    public function anggotaKeluarga()
    {
        return $this->hasMany(AnggotaKeluarga::class, 'tree_id', 'id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
