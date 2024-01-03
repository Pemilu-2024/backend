<?php

namespace App\Repositories;

use App\Models\Konten;
use App\Models\Interaksi;
use App\Models\Komen;

class KontenRepository
{
    protected $kontenModel;
    protected $interaksiModel;
    protected $komenModel;

    public function __construct(Konten $kontenModel, Interaksi $interaksiModel, Komen $komenModel)
    {
        $this->kontenModel = $kontenModel;
        $this->interaksiModel = $interaksiModel;
        $this->komenModel = $komenModel;
    }

    public function listKonten()
    {
        $data = $this->kontenModel->get();
        return $data;
    }

    public function detailKonten($id)
    {
        $data = $this->kontenModel->find($id);
        return $data;
    }

    public function createKonten(array $dataRequest)
    {
        $data = $this->kontenModel->insert($dataRequest);
        return $data;
    }

    public function updateKonten(array $dataRequest, $id)
    {
        try {
            $dataKonten = Konten::findOrFail($id);
            // Update data
            $dataKonten->gambar = $dataRequest['gambar'];
            $dataKonten->judul = $dataRequest['judul'];
            $dataKonten->deskripsi = $dataRequest['deskripsi'];
            $dataKonten->userId = $dataRequest['userId'];
            $dataKonten->save();
            return true; 
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
    
        // Cek apakah userId tersebut sudah pernah memberikan reaksi
        $existingReaksi = $this->interaksiModel
            ->where('userId', $data['userId'])
            ->where('kontenId', $id)
            ->first();
    
        // Jika sudah pernah, lakukan update
        if ($existingReaksi) {
            // Lakukan logika untuk meng-update reaksi yang sudah ada
            
            // cek apakah reaksi yang sudah ada sama dengan yang baru
            $temp = $this->interaksiModel
            ->where('userId', $data['userId'])
            ->where('kontenId', $id)
            ->first();

            $temp->delete();
            
            // $existingReaksi->update(['reaksi' => $data['reaksi']]);
            // if ($data['reaksi'] == '0' && $temp->reaksi != '0') {
            //     $this->kontenModel->where('id', $id)->increment('jumlahDislike');
                $this->kontenModel->where('id', $id)->decrement('jumlahLike');
            // }
    
            // if ($data['reaksi'] == '1' && $temp->reaksi != '1') {
            //     $this->kontenModel->where('id', $id)->increment('jumlahLike');
            //     $this->kontenModel->where('id', $id)->decrement('jumlahDislike');
            // }
        } else {
            // Jika belum, lakukan insert data baru
            $data['kontenId'] = $id;
            $this->interaksiModel->create($data);
            
            // Lakukan penambahan jumlahLike atau jumlahDislike berdasarkan nilai reaksi
            if ($data['reaksi'] == '0') {
                $this->kontenModel->where('id', $id)->increment('jumlahDislike');
            }
            if ($data['reaksi'] == '1') {
                $this->kontenModel->where('id', $id)->increment('jumlahLike');
            }
        }
    }

    public function isLike(array $dataRequest)
    {
        return $this->interaksiModel
            ->where('userId', $dataRequest['userId'])
            ->where('kontenId', $dataRequest['kontenId'])
            ->first();

    }

    public function listKomenbyIdKonten($id)
    {
        $data = $this->komenModel
            ->select('komens.*', 'users.nama as nama_user')
            ->join('users', 'komens.userId', '=', 'users.id')
            ->where('kontenId', $id)
            ->get();

        return $data;
    }


    public function komenKonten(array $dataRequest, $id)
    {
        $data = [
            'komen' => $dataRequest['komen'],
            'userId' => $dataRequest['userId'],
            'kontenId' => $id,
        ];
        // $data['kontenId'] = $id;
        $this->komenModel->create($data);
        $this->kontenModel->where('id', $id)->increment('jumlahKomen');
        return true;
    }

    public function hapusKomen($id)
    {
        $data = $this->interaksiModel->find($id);
        return $data->delete();
    }

    public function hapusKonten($id)
    {
        $data = $this->detailKonten($id);
        return $data->delete();
    }
}