<?php

namespace App\Services;

use App\Repositories\AspirasiRepository;

class AspirasiService
{
    protected $aspirasiRepository;

    public function __construct(AspirasiRepository $aspirasiRepository)
    {
        $this->aspirasiRepository = $aspirasiRepository;
    }

    public function listAspirasi()
    {
        return $this->aspirasiRepository->listAspirasi();
    }

    public function listAspirasiByUserId($id)
    {
        return $this->aspirasiRepository->listAspirasiByUserId($id);
    }

    public function createAspirasi(array $dataRequest)
    {
        $data = [
            'nama' => $dataRequest['nama'],
            'alamat' => $dataRequest['alamat'],
            'jenis_aspirasi' => $dataRequest['jenis_aspirasi'],
            'aspirasi' => $dataRequest['aspirasi'],
            'userId' => $dataRequest['userId'],
        ];
        return $this->aspirasiRepository->createAspirasi($data);
    }

    public function updateAspirasi(array $request, $id)
    {}

    public function deleteAspirasi($id)
    {
        return $this->aspirasiRepository->deleteAspirasi($id);
    }
}