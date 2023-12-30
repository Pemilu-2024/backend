<?php

namespace App\Services;

use App\Repositories\FeedbackRepository;

class FeedbackService
{
    protected $feedbackRepository;

    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }

    public function listFeedback()
    {
        return $this->feedbackRepository->listFeedback();
    }

    public function listFeedbackByUserId($id)
    {
        return $this->feedbackRepository->listFeedbackByUserId($id);
    }

    public function createFeedback(array $dataRequest)
    {
        $data = [
            'rating' => $dataRequest['rating'],
            'nama' => $dataRequest['nama'],
            'alamat' => $dataRequest['alamat'],
            'aspirasi' => $dataRequest['aspirasi'],
            'userId' => $dataRequest['userId'],
        ];
        return $this->feedbackRepository->createFeedback($data);
    }

    public function updateFeedback(array $request, $id)
    {}

    public function deleteFeedback($id)
    {
        return $this->feedbackRepository->deleteFeedback($id);
    }
}