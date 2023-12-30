<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FeedbackService;
use App\Helpers\FormatApi;

class FeedbackController extends Controller
{
    protected $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    public function listFeedback()
    {
        $result = $this->feedbackService->listFeedback();
        return $this->formatApiResponse($result, 'get data list feedback successfully', 200);
    }

    public function listFeedbackByUserId($id)
    {
        $result = $this->feedbackService->listFeedbackByUserId($id);
        return $this->formatApiResponse($result, 'get data detail feedback successfully', 200);
    }

    public function createFeedback(Request $request)
    {
        try {
            // Validasi data
            $validateData = $this->validateFeedback($request);
    
            // kirim data ke service
            $result = $this->feedbackService->createFeedback($validateData);
    
            // berikan response
            return $this->formatApiResponse($result, 'create kandidat successfully', 201);
        } catch (\Throwable $th) {
            // ambil error message
            $errorMessage = $th->getMessage();
            return $this->formatApiResponse(null, $errorMessage, 500);
        }
    }

    public function updateFeedback(Request $request, $id)
    {}

    public function deleteFeedback($id)
    {
        $result = $this->feedbackService->deleteFeedback($id);
        return $this->formatApiResponse($result, 'delete data feedback successfully', 200);
    }

      // =============== general function ==============

      private function validateFeedback(Request $request)
      {
          try {
              return $request->validate([
                  'umur' => 'required|numeric',
                  'alamat' => 'required|string',
                  'kepuasan' => 'required|numeric',
                  'saran' => 'required|string',
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