<?php

namespace App\Services;

use App\Repositories\KandidatRepository;

class KandidatService
{
    protected $kandidatRepository;

    public function __construct(KandidatRepository $kandidatRepository)
    {
        $this->kandidatRepository = $kandidatRepository;
    }

    public function listKandidat()
    {
        return $this->kandidatRepository->listKandidat();
    }
    
    public function detailKandidat($id)
    {
        return $this->kandidatRepository->detailKandidat($id);
    }

    public function createKandidat(array $dataRequest)
    {
        $images = $dataRequest['gambarKandidat'];
        $images->storeAs('public/gambarKandidat', $images->hashName());
        $data = [
            'gambarKandidat' => $images->hashName(),
            'noUrut' => $dataRequest['noUrut'],
            'namaCalon' => $dataRequest['namaCalon'],
            'namaWakilCalon' => $dataRequest['namaWakilCalon']
        ];
        return $this->kandidatRepository->createKandidat($data);
    }
    
    public function updateKandidat(array $dataRequest, $id)
    {
        try {
            // Dapatkan data lama
            $oldKandidatData = $this->kandidatRepository->detailKandidat($id);
            if (!$oldKandidatData) {
                return $this->formatApiResponse(null, 'Data not found', 404);
            }

            // Hapus gambar lama
            $oldImagePath = storage_path('app/public/gambarKandidat/') . $oldKandidatData->gambarKandidat;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Upload gambar baru
            $newImage = $dataRequest['gambarKandidat'];
            $newImage->storeAs('public/gambarKandidat', $newImage->hashName());

            // Update data
            $data = [
                'gambarKandidat' => $newImage->hashName(),
                'noUrut' => $dataRequest['noUrut'],
                'namaCalon' => $dataRequest['namaCalon'],
                'namaWakilCalon' => $dataRequest['namaWakilCalon'],
            ];

            

            return $this->kandidatRepository->updateKandidat($data, $id);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function inputJumlahSuara(array $request)
    {}


    public function deleteKandidat($id)
    {
        return $this->kandidatRepository->deleteKandidat($id);
    }
}