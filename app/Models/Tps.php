<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tps extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'provinsi',
        'kota',
        'kecamatan',
        'desa',
        'status',
        'koordinat',
        'userId',
    ];
}
