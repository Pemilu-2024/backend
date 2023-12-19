<?php

namespace App\Services;

use App\Repositories\KontenRepository;

class KontenService
{
    protected $kontenRepository;

    public function __construct(KontenRepository $kontenRepository)
    {
        $this->kontenRepository = $kontenRepository;
    }

    public function listKonten()
    {
        return $this->kontenRepository->listKonten();
    }
    
    public function detailKonten($id)
    {
        return $this->kontenRepository->detailKonten($id);
    }

    public function createKonten(array $dataRequest)
    {
        $images = $dataRequest['gambar'];
        $images->storeAs('public/konten', $images->hashName());
        $data = [
            'gambar' => $images->hashName(),
            'judul' => $dataRequest['judul'],
            'deskripsi' => $dataRequest['deskripsi'],
            'userId' => $dataRequest['userId'],
        ];
        return $this->kontenRepository->createKonten($data);
    }

    public function updateKonten(array $dataRequest, $id)
    {
        try {
            // Dapatkan data lama
            $oldKontenData = $this->kontenRepository->detailKonten($id);
            if (!$oldKontenData) {
                return $this->formatApiResponse(null, 'Data not found', 404);
            }

            // Hapus gambar lama
            $oldImagePath = storage_path('app/public/konten/') . $oldTpsData->fileBukti;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Upload gambar baru
            $newImage = $dataRequest['gambar'];
            $newImage->storeAs('public/konten', $newImage->hashName());

            // Update data
            $data = [
                'gambar' => $images->hashName(),
                'judul' => $dataRequest['judul'],
                'deskripsi' => $dataRequest['deskripsi'],
                'userId' => $dataRequest['userId'],
            ];

            

            return $this->kontenRepository->updateKonten($data, $id);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function reaksiKonten(array $dataRequest, $id)
    {
        $data = [
            'reaksi' => $dataRequest['reaksi'],
            'userId' => $dataRequest['userId'],
            // 'kontenId' => $dataRequest['kontenId'],
        ];
        return $this->kontenRepository->reaksiKonten($data, $id);
    }

    public function komenKonten(array $dataRequest, $id)
    {
        $data = [
            'komen' => $dataRequest['komen'],
            'userId' => $dataRequest['userId'],
        ];
        return $this->kontenRepository->komenKonten($data, $id);
    }

    public function hapusKomen($id)
    {
        return $this->kontenRepository->hapusKomen($id);
    }
    
    public function hapusKonten($id)
    {
        return $this->kontenRepository->hapusKonten($id);
    }
}