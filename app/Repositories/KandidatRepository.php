<?php

namespace App\Repositories;
use App\Models\Kandidat;

class KandidatRepository
{
    protected $kandidatModel;

    public function __construct(Kandidat $kandidat)
    {
        $this->kandidatModel = $kandidat;
    }

    public function listKandidat()
    {
        $data = $this->kandidatModel->get();
        return $data;   
    }

    public function detailKandidat($id)
    {
        $data = $this->kandidatModel->find($id);
        return $data;
    }

    public function createKandidat(array $dataRequest)
    {
        $data = $this->kandidatModel->insert($dataRequest);
        return $data;
    }
    
    public function updateKandidat(array $dataRequest, $id)
    {
        try {
            $kandidat = Kandidat::findOrFail($id);

            // Update data
            $kandidat->gambarKandidat = $dataRequest['gambarKandidat'];
            $kandidat->noUrut = $dataRequest['noUrut'];
            $kandidat->namaCalon = $dataRequest['namaCalon'];
            $kandidat->namaWakilCalon = $dataRequest['namaWakilCalon'];

            $kandidat->save();

            return true; 
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function inputJumlahSuara(array $dataRequest)
    {}


    public function deleteKandidat($id)
    {
        $data = $this->kandidatModel->find($id);
        return $data->delete();
    }
}