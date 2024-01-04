<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LaporanKecuranganService;
use App\Helpers\FormatApi;

class LaporanKecuranganController extends Controller
{
    protected $laporanKecuranganService;

    public function __construct(LaporanKecuranganService $laporanKecuranganService)
    {
        $this->laporanKecuranganService = $laporanKecuranganService;
    }

    public function listLaporanKecurangan()
    {
        $result = $this->laporanKecuranganService->listLaporanKecurangan();
        if ($result) {
            return $this->formatApiResponse($result, 'berhasil', 200);
        }
        return $this->formatApiResponse($result, 'data kosong', 200);
    }

    public function detailLaporanKecurangan($id)
    {
        $result = $this->laporanKecuranganService->detailLaporanKecurangan($id);
        if ($result) {
            return $this->formatApiResponse($result, 'berhasil', 200);
        }
        return $this->formatApiResponse($result, 'data kosong', 200);
    }

    public function createLaporanKecurangan(Request $request)
    {
        try {
            // Validasi data
            $validateData = $this->validateLaporanData($request);
    
            // kirim data ke service
            $result = $this->laporanKecuranganService->createLaporanKecurangan($validateData);
    
            // berikan response
            return $this->formatApiResponse($result, 'berhasil', 201);
        } catch (\Throwable $th) {
            // ambil error message
            $errorMessage = $th->getMessage();
            return $this->formatApiResponse(null, $errorMessage, 500);
        }
    }

    public function deleteLaporanKecurangan($id)
    {
        $result = $this->laporanKecuranganService->deleteLaporanKecurangan($id);
        if ($result) {
            return $this->formatApiResponse($result, 'berhasil', 200);
        }
        return $this->formatApiResponse($result, 'gagal', 200);
    }

     // =============== general function ==============

     private function validateLaporanData(Request $request)
     {
         try {
             return $request->validate([
                'bukti_kecurangan' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'lokasi_kecurangan' => 'required|string',
                'deskripsi_kecurangan' => 'required|string',
                'user_id' => 'required|numeric',
             ]);
         } catch (ValidationException $e) {
             return $e->errors();
         }
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
