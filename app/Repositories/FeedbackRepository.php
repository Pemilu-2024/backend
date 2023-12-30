<?php

namespace App\Repositories;

use App\Models\Feedback;

class FeedbackRepository
{
    protected $feedbackModel;

    public function __construct(Feedback $feedbackModel)
    {
        $this->feedbackModel = $feedbackModel;
    }

    public function listFeedback()
    {
        return $this->feedbackModel->get();
    }

    public function listFeedbackByUserId($id)
    {
        return $this->feedbackModel->where('user_id', $id)->get();
    }

    public function createFeedback(array $dataRequest)
    {
        return $this->feedbackModel->create($dataRequest);
    }

    public function deleteFeedback($id)
    {
        $feedback = $this->feedbackModel->find($id);

        if ($feedback) {
            $feedback->delete();
            return true;
        }

        return false;
    }
}
