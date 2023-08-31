<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use DateTime;

class AnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'question' => new QuestionResource($this->question),
            'submission' => new SubmissionResource($this->submission),
            'answer' => json_decode($this->answer) ? json_decode($this->answer) : $this->answer,
            'create_at' => (new DateTime($this->end_date))->format('Y-m-d H:i:s'),

        ];
    }
}
