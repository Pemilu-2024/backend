<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kandidat;
use Illuminate\Support\Facades\Hash;

class KandidatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kandidat::create([
            'noUrut' => '01',
            'gambarKandidat' => 'gambar kandidat satu',
            'namaCalon' => 'Anies Baswedan',
            'namaWakilCalon' => 'Cak Imin',
        ]);
        Kandidat::create([
            'noUrut' => '02',
            'gambarKandidat' => 'gambar kandidat dua',
            'namaCalon' => 'Prabowo Subianto',
            'namaWakilCalon' => 'Gibran Raka Buming Raka',
        ]);
        Kandidat::create([
            'noUrut' => '03',
            'gambarKandidat' => 'gambar kandidat tiga',
            'namaCalon' => 'Ganjar Pranowo',
            'namaWakilCalon' => 'Mahfud MD',
        ]);
        Kandidat::create([
            'noUrut' => '00',
            'gambarKandidat' => 'gambar suara rusak',
            'namaCalon' => 'suara rusak',
            'namaWakilCalon' => 'suara rusak',
        ]);
    }
}
