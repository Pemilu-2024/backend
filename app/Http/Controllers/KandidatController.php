<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KandidatService;
use App\Helpers\FormatApi;

class KandidatController extends Controller
{
    protected $kandidatService;

    public function __construct(KandidatService $kandidatService)
    {
        $this->kandidatService = $kandidatService;
    }

    public function listKandidat()
    {
        $result = $this->kandidatService->listKandidat();
        return $this->formatApiResponse($result, 'get data list kandidat successfully', 200);
    }

    public function detailKandidat($id)
    {
        $result = $this->kandidatService->detailKandidat($id);
        return $this->formatApiResponse($result, 'get data list kandidat successfully', 200);
    }

    public function createKandidat(Request $request)
    {
        try {
            // Validasi data
            $validateData = $this->validateKandidatData($request);
    
            // kirim data ke service
            $result = $this->kandidatService->createKandidat($validateData);
    
            // berikan response
            return $this->formatApiResponse($result, 'create kandidat successfully', 201);
        } catch (\Throwable $th) {
            // ambil error message
            $errorMessage = $th->getMessage();
            return $this->formatApiResponse(null, $errorMessage, 500);
        }
    }
    
    public function updateKandidat(Request $request, $id)
    {
        try {
            // Validasi data
            $validateData = $this->validateKandidatData($request);
    
            // kirim data ke service
            $result = $this->kandidatService->updateKandidat($validateData, $id);

            if ($result) {
                return $this->formatApiResponse($result, 'update data kandidat successfully', 200);
            }
            return $this->formatApiResponse($result, 'update data kandidat failed', 200);
        } catch (\Throwable $th) {
            // ambil error message
            $errorMessage = $th->getMessage();
            return $this->formatApiResponse(null, $errorMessage, 500);
        }
    }

    public function inputJumlahSuara(Request $request)
    {
        try {
            $validateData = $request->validate([
                'komen' => 'required|numeric',
                'userId' => 'required|numeric',
            ]);   
            $result = $this->kontenService->komenKonten($validateData);
            if ($result) {
                return $this->formatApiResponse($result, 'update data konten successfully', 200);
            }
        } catch (\Throwable $th) {
             // ambil error message
             $errorMessage = $th->getMessage();
             return $this->formatApiResponse(null, $errorMessage, 500);
        }
    }


    public function deleteKandidat($id)
    {
        $result = $this->kandidatService->deleteKandidat($id);
        return $this->formatApiResponse($result, 'delete data kandidat successfully', 200);
    }

    // =============== general function ==============

    private function validateKandidatData(Request $request)
    {
        try {
            return $request->validate([
                'noUrut' => 'required|numeric',
                'gambarKandidat' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'namaCalon' => 'required|string',
                'namaWakilCalon' => 'required|string',
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
