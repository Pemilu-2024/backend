<?php

namespace App\Repositories;

use App\Models\LaporanKecurangan;

class LaporanKecuranganRepository
{
    protected $laporanKecuranganModel;

    public function __construct(LaporanKecurangan $laporanKecuranganModel)
    {
        $this->laporanKecuranganModel = $laporanKecuranganModel;
    }

    public function listLaporanKecurangan()
    {
        return $this->laporanKecuranganModel->get();
    }

    public function detailLaporanKecurangan($id)
    {
        $data = $this->laporanKecuranganModel->find($id);
        return $data;
    }

    public function createLaporanKecurangan(array $dataRequest)
    {
        $data = $this->laporanKecuranganModel->insert($dataRequest);
        return $data;  
    }

    public function deleteLaporanKecurangan($id)
    {
        $data = $this->laporanKecuranganModel->find($id);
        return $data->delete();
    }
}