<?php

namespace App\Repositories;

use App\Models\PusatInformasi;

class PusatInformasiRepository
{
    protected $pusatInformasiModel;

    public function __construct(PusatInformasi $pusatInformasiModel)
    {
        $this->pusatInformasiModel = $pusatInformasiModel;
    }


    public function listInformasi()
    {
        return $this->pusatInformasiModel->get();
    }
    
    public function detailInformasi($id)
    {
        return $this->pusatInformasiModel->find($id);
    }

    public function createInformasi(array $dataRequest)
    {
        $data = $this->pusatInformasiModel->insert($dataRequest);
       
        return $data;
    }

    public function updateInformasi(array $dataRequest, $id)
    {
        try {
            $dataInformasi = PusatInformasi::findOrFail($id);

            // Update data
            $dataInformasi->judul = $dataRequest['judul'];
            $dataInformasi->deskripsi = $dataRequest['deskripsi'];
        
            $dataInformasi->save();

            return true; 
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function deleteInformasi($id)
    {
       $data = $this->pusatInformasiModel->find($id);
        return $data->delete();
    }
}