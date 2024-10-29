<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'no_telp',
        'no_induk',
        'asal_institusi',
        'jurusan',
        'bidang_diambil',
        'surat_pengantar',
        'tanggal_awal_magang',
        'tanggal_akhir_magang',
        'approve_magang',
        'nilai_magang'
    ];

    protected function casts(): array
    {
        return [
            'tanggal_awal_magang' => 'datetime',
            'tanggal_akhir_magang' => 'datetime',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
