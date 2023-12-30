<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KontenService;
use App\Helpers\FormatApi;

class KontenController extends Controller
{
    protected $kontenService;

    public function __construct(KontenService $kontenService)
    {
        $this->kontenService = $kontenService;
    }

    // ============= user access ===============
    public function listKonten()
    {
        $result = $this->kontenService->listKonten();
        return $this->formatApiResponse($result, 'get data list konten successfully', 200);
    }

    public function detailKonten($id)
    {
        $result = $this->kontenService->detailKonten($id);
        return $this->formatApiResponse($result, 'get data detail konten successfully', 200);
    }

    public function reaksiKonten(Request $request, $id)
    {
        try {
            $validateData = $request->validate([
                'reaksi' => 'required|string',
                'userId' => 'required|numeric',
                // 'kontenId' => 'required|numeric',
            ]);   
            $result = $this->kontenService->reaksiKonten($validateData, $id);
            if ($result) {
                return $this->formatApiResponse($result, 'update data konten successfully', 200);
            }
        } catch (\Throwable $th) {
             // ambil error message
             $errorMessage = $th->getMessage();
             return $this->formatApiResponse(null, $errorMessage, 500);
        }
    }

    public function listKomenbyIdKonten($id)
    {
        $result = $this->kontenService->listKomenbyIdKonten($id);
        return $this->formatApiResponse($result, 'get data list komen successfully', 200);
    }

    public function komenKonten(Request $request, $id)
    {
        try {
            $validateData = $request->validate([
                'komen' => 'required|string',
                'userId' => 'required|numeric',
            ]);   
            $result = $this->kontenService->komenKonten($validateData, $id);
            if ($result) {
                return $this->formatApiResponse($result, 'update data konten successfully', 200);
            }
        } catch (\Throwable $th) {
             // ambil error message
             $errorMessage = $th->getMessage();
             return $this->formatApiResponse(null, $errorMessage, 500);
        }
    }


    // ============= admin access ===============

    public function createKonten(Request $request)
    {
        try {
            // Validasi data
            $validateData = $this->validateTpsData($request);
    
            // kirim data ke service
            $result = $this->kontenService->createKonten($validateData);
    
            // berikan response
            return $this->formatApiResponse($result, 'create konten successfully', 201);
        } catch (\Throwable $th) {
            // ambil error message
            $errorMessage = $th->getMessage();
            return $this->formatApiResponse(null, $errorMessage, 500);
        }
    }

    public function updateKonten(Request $request, $id)
    {
        try {
            // Validasi data
            $validateData = $this->validateTpsData($request);
    
            // kirim data ke service
            $result = $this->kontenService->updateKonten($validateData, $id);

            if ($result) {
                return $this->formatApiResponse($result, 'update data konten successfully', 200);
            }
            return $this->formatApiResponse($result, 'update data konten failed', 200);
        } catch (\Throwable $th) {
            // ambil error message
            $errorMessage = $th->getMessage();
            return $this->formatApiResponse(null, $errorMessage, 500);
        }
    }

    public function hapusKomen($id)
    {
        try {
            return $this->formatApiResponse($this->tpsService->hapusKomen($id), 'delete komen successfully', 200);
        } catch (\Throwable $th) {
            // ambil error message
            $errorMessage = $th->getMessage();
            return $this->formatApiResponse(null, $errorMessage, 500);
        }
    }

    public function hapusKonten($id)
    {
        try {
            return $this->formatApiResponse($this->tpsService->hapusKonten($id), 'delete konten successfully', 200);
        } catch (\Throwable $th) {
            // ambil error message
            $errorMessage = $th->getMessage();
            return $this->formatApiResponse(null, $errorMessage, 500);
        }
    }



    // =============== general function ==============

    private function validateTpsData(Request $request)
    {
        return $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'userId' => 'required|numeric',
        ]);
    }

    public function formatApiResponse($data, $message, $statusCode)
    {
        if ($data) {
            return FormatApi::ApiCreate($statusCode, $message, $data);
        } else {
            return FormatApi::ApiCreate($statusCode, $message);
        }
    }
}
