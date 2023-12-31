<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    use HasFactory;

    protected $fillable = [
        'gambar',
        'judul',
        'deskripsi',
        'jumlahLike',
        'jumlahDislike',
        'jumlahKomen',
        'userId',
    ];
}
