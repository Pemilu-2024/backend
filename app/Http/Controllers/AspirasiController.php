<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AspirasiService;
use App\Helpers\FormatApi;

class AspirasiController extends Controller
{
    protected $aspirasiService;

    public function __construct(AspirasiService $aspirasiService)
    {
        $this->aspirasiService = $aspirasiService;
    }

    public function listAspirasi()
    {
        $result = $this->aspirasiService->listAspirasi();
        return $this->formatApiResponse($result, 'get data list aspirasi successfully', 200);
    }

    public function listAspirasiByUserId($id)
    {
        $result = $this->aspirasiService->listAspirasiByUserId($id);
        return $this->formatApiResponse($result, 'get data detail aspirasi successfully', 200);
    }

    public function createAspirasi(Request $request)
    {
        try {
            // Validasi data
            $validateData = $this->validateAspirasi($request);
    
            // kirim data ke service
            $result = $this->aspirasiService->createAspirasi($validateData);
    
            // berikan response
            return $this->formatApiResponse($result, 'create aspirasi successfully', 201);
        } catch (\Throwable $th) {
            // ambil error message
            $errorMessage = $th->getMessage();
            return $this->formatApiResponse(null, $errorMessage, 500);
        }
    }

    public function updateAspirasi(Request $request, $id)
    {}

    public function deleteAspirasi($id)
    {
        $result = $this->aspirasiService->deleteAspirasi($id);
        return $this->formatApiResponse($result, 'delete data aspirasi successfully', 200);
    }

      // =============== general function ==============

      private function validateAspirasi(Request $request)
      {
          try {
              return $request->validate([
                  'nama' => 'required|string',
                  'alamat' => 'required|string',
                  'jenis_aspirasi' => 'required|string',
                  'aspirasi' => 'required|string',
                  'userId' => 'required|numeric',
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
