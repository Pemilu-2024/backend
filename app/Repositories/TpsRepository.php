<?php

namespace App\Repositories;

use App\Models\Tps;

class TpsRepository
{
    protected $tpsModel;

    public function __construct(Tps $tpsModel)
    {
        $this->tpsModel = $tpsModel;
    }

    public function listTps()
    {
        $data = $this->tpsModel->get();
        return $data;
    }

    public function detailTps($id)
    {
        $data = $this->tpsModel->find($id);

        return $data;
    }

    public function createTps(array $dataRequest)
    {
        $data = $this->tpsModel->insert($dataRequest);
        return $data;
    }

    public function updateTps(array $dataRequest, $id)
    {
        try {
            $tps = Tps::findOrFail($id);

            // Update data
            $tps->nama = $dataRequest['nama'];
            $tps->provinsi = $dataRequest['provinsi'];
            $tps->kota = $dataRequest['kota'];
            $tps->kecamatan = $dataRequest['kecamatan'];
            $tps->desa = $dataRequest['desa'];
            $tps->koordinat = $dataRequest['koordinat'];
            $tps->userId = $dataRequest['userId'];

            $tps->save();

            return true; 
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function deleteTps($id)
    {
        $data = $this->detailTps($id);
        return $data->delete();
    }
}