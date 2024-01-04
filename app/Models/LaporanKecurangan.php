<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKecurangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'bukti_kecurangan',
        'lokasi_kecurangan',
        'deskripsi_kecurangan',
        'user_id'
    ];
}
