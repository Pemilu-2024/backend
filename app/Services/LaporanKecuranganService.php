<?php

namespace App\Services;

use App\Repositories\LaporanKecuranganRepository;

class LaporanKecuranganService
{
    protected $laporanKecuranganRepository;

    public function __construct(LaporanKecuranganRepository $laporanKecuranganRepository)
    {
        $this->laporanKecuranganRepository = $laporanKecuranganRepository;
    }

    public function listLaporanKecurangan()
    {
        return $this->laporanKecuranganRepository->listLaporanKecurangan();
    }

    public function detailLaporanKecurangan($id)
    {
        return $this->laporanKecuranganRepository->detailLaporanKecurangan($id);
    }

    public function createLaporanKecurangan(array $dataRequest)
    {
        $images = $dataRequest['bukti_kecurangan'];
        $images->storeAs('public/bukti_kecurangan', $images->hashName());
        $data = [
            'bukti_kecurangan' => $images->hashName(),
            'lokasi_kecurangan' => $dataRequest['lokasi_kecurangan'],
            'deskripsi_kecurangan' => $dataRequest['deskripsi_kecurangan'],
            'user_id' => $dataRequest['user_id']
        ];
        return $this->laporanKecuranganRepository->createLaporanKecurangan($data);   
    }

    public function deleteLaporanKecurangan($id)
    {
        return $this->laporanKecuranganRepository->deleteLaporanKecurangan($id);
    }
}