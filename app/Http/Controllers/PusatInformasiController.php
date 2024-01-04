<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PusatInformasiService;
use App\Helpers\FormatApi;

class PusatInformasiController extends Controller
{
    protected $pusatInformasiService;

    public function __construct(PusatInformasiService $pusatInformasiService)
    {
        $this->pusatInformasiService = $pusatInformasiService;
    }

    public function listInformasi()
    {
        $result = $this->pusatInformasiService->listInformasi();

        if ($result) {
            return $this->formatApiResponse($result, 'berhasil', 200);
        }
        return $this->formatApiResponse($result, 'gagal', 200);
    }
    
    public function detailInformasi($id)
    {
        $result = $this->pusatInformasiService->listInformasi();
    
        if ($result) {
            return $this->formatApiResponse($result, 'berhasil', 200);
        }
        return $this->formatApiResponse($result, 'gagal', 200);
        
    }

    public function createInformasi(Request $request)
    {
        try {
            // Validasi data
            $validateData = $this->validateInformasiData($request);
    
            // kirim data ke service
            $result = $this->pusatInformasiService->createInformasi($validateData);
    
            // berikan response
            return $this->formatApiResponse($result, 'berhasil', 201);
        } catch (\Throwable $th) {
            // ambil error message
            $errorMessage = $th->getMessage();
            return $this->formatApiResponse(null, $errorMessage, 500);
        }
    }

    public function updateInformasi(Request $request, $id)
    {
        try {
            // Validasi data
            $validateData = $this->validateInformasiData($request);
    
            // kirim data ke service
            $result = $this->pusatInformasiService->updateInformasi($validateData, $id);

            if ($result) {
                return $this->formatApiResponse($result, 'update berhasil', 200);
            }
            return $this->formatApiResponse($result, 'update gagal', 200);
        } catch (\Throwable $th) {
            // ambil error message
            $errorMessage = $th->getMessage();
            return $this->formatApiResponse(null, $errorMessage, 500);
        }
    }

    public function deleteInformasi($id)
    {
        $result = $this->pusatInformasiService->deleteInformasi($id);
        if ($result) {
            return $this->formatApiResponse($result, 'berhasil', 200);
        }
        return $this->formatApiResponse($result, 'gagal', 200);
    }

    // =============== general function ==============

    private function validateInformasiData(Request $request)
    {
        try {
            return $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string'
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
