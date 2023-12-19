<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TpsService;
use App\Helpers\FormatApi;

class TpsController extends Controller
{
    protected $tpsService;

    public function __construct(TpsService $tpsService)
    {
        $this->tpsService = $tpsService;
    }

    public function listTps()
    {
        return $this->formatApiResponse($this->tpsService->listTps(), 'get data list tps successfully', 200);
    }

    public function detailTps($id)
    {
        try {
            $result = $this->tpsService->detailTps($id);
            if($result != null){
                return $this->formatApiResponse($result, 'get data detail tps successfully', 200);
            }else{
                return $this->formatApiResponse($result, 'data detail tps kosong', 200);
            }
        } catch (\Throwable $th) {
            // ambil error message
            $errorMessage = $th->getMessage();
            return $this->formatApiResponse(null, $errorMessage, 500);
        }
    }

    public function createTps(Request $request)
    {
        try {
            // Validasi data
            $validateData = $this->validateTpsData($request);
    
            // kirim data ke service
            $result = $this->tpsService->createTps($validateData);
    
            // berikan response
            return $this->formatApiResponse($result, 'create tps successfully', 200);
        } catch (\Throwable $th) {
            // ambil error message
            $errorMessage = $th->getMessage();
            return $this->formatApiResponse(null, $errorMessage, 500);
        }
    }

    public function updateTps(Request $request, $id)
    {
        try {
            // Validasi data
            $validateData = $this->validateTpsData($request);
            
            // kirim data ke service
            $result = $this->tpsService->updateTps($validateData, $id);

            if ($result) {
                return $this->formatApiResponse($result, 'update data tps successfully', 200);
            }
            return $this->formatApiResponse($result, 'update data tps failed', 401);
        } catch (\Throwable $th) {
            // ambil error message
            $errorMessage = $th->getMessage();
            return $this->formatApiResponse(null, $errorMessage, 500);
        }
    }

    public function deleteTps($id)
    {
        try {
            return $this->formatApiResponse($this->tpsService->deleteTps($id), 'delete data tps successfully', 200);
        } catch (\Throwable $th) {
            // ambil error message
            $errorMessage = $th->getMessage();
            return $this->formatApiResponse(null, $errorMessage, 500);
        }
    }

    private function validateTpsData(Request $request)
    {
        return $request->validate([
            'nama' => 'required|string',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'kecamatan' => 'required|string',
            'desa' => 'required|string',
            'koordinat' => 'required|string',
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






