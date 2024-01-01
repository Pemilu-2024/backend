<?php

namespace App\Repositories;

use App\Models\Aspirasi;

class AspirasiRepository
{
    protected $aspirasiModel;

    public function __construct(Aspirasi $aspirasiModel)
    {
        $this->aspirasiModel = $aspirasiModel;
    }

    public function listAspirasi()
    {
        return $this->aspirasiModel->get();
    }

    public function listAspirasiByUserId($id)
    {
        return $this->aspirasiModel->where('user_id', $id)->get();
    }

    public function createAspirasi(array $dataRequest)
    {
        return $this->aspirasiModel->create($dataRequest);
    }

    public function deleteAspirasi($id)
    {
        $aspirasi = $this->aspirasiModel->find($id);

        if ($aspirasi) {
            $aspirasi->delete();
            return true;
        }

        return false;
    }
}
