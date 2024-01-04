<?php

namespace App\Services;

use App\Repositories\PusatInformasiRepository;

class PusatInformasiService
{
    protected $pusatInformasiRepository;

    public function __construct(PusatInformasiRepository $pusatInformasiRepository)
    {
        $this->pusatInformasiRepository = $pusatInformasiRepository;
    }

    public function listInformasi()
    {
        return $this->pusatInformasiRepository->listInformasi();
    }
    
    public function detailInformasi($id)
    {
        return $this->pusatInformasiRepository->detailInformasi($id);
    }

    public function createInformasi(array $dataRequest)
    {
        $data = [
            'judul' => $dataRequest['judul'],
            'deskripsi' => $dataRequest['deskripsi'],
        ];
        return $this->pusatInformasiRepository->createInformasi($data);
    }

    public function updateInformasi(array $dataRequest, $id)
    {
        $data = [
            'judul' => $dataRequest['judul'],
            'deskripsi' => $dataRequest['deskripsi'],
        ];
        return $this->pusatInformasiRepository->updateInformasi($data, $id);
    }

    public function deleteInformasi($id)
    {
       return $this->pusatInformasiRepository->deleteInformasi($id);
    }
}