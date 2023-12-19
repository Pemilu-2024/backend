<?php

namespace App\Services;

use App\Repositories\TpsRepository;

class TpsService
{
    protected $tpsRepository;

    public function __construct(TpsRepository $tpsRepository)
    {
        $this->tpsRepository = $tpsRepository;
    }

    public function listTps()
    {
        return $this->tpsRepository->listTps();
    }

    public function detailTps($id)
    {
        return $this->tpsRepository->detailTps($id);
    }

    public function createTps(array $dataRequest)
    {
        $data = [
            'nama' => $dataRequest['nama'],
            'provinsi' => $dataRequest['provinsi'],
            'kota' => $dataRequest['kota'],
            'kecamatan' => $dataRequest['kecamatan'],
            'desa' => $dataRequest['desa'],
            'koordinat' => $dataRequest['koordinat'],
            'userId' => $dataRequest['userId'],
        ];
        return $this->tpsRepository->createTps($data);
    }
    
    public function updateTps(array $dataRequest, $id)
    {
        try {
            // Update data
            $data = [
                'nama' => $dataRequest['nama'],
                'provinsi' => $dataRequest['provinsi'],
                'kota' => $dataRequest['kota'],
                'kecamatan' => $dataRequest['kecamatan'],
                'desa' => $dataRequest['desa'],
                'koordinat' => $dataRequest['koordinat'],
                'userId' => $dataRequest['userId'],
            ];

            

            return $this->tpsRepository->updateTps($data, $id);
        } catch (\Throwable $th) {
            return false;
        }
    }

    
    public function deleteTps($id)
    {
        return $this->tpsRepository->deleteTps($id);
    }
}