<?php

namespace App\Http\Controllers;

use App\Events\SurveySubmitted;
use App\Http\Requests\StoreAnswerRequest;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\SubmissionResource;
use App\Models\Answer;
use App\Models\Submission;
use App\Models\Survey;


class SubmissionController extends Controller
{

    public function showSurveySubmissions(Survey $survey)
    {
        if (auth()->user()->id !== $survey->user_id)
        {
            return response(['message' => 'Unauthorized action.'], 403);
        }
        return  SubmissionResource::collection(Submission::where('survey_id', $survey->id)->orderBy('start_date', 'DESC')->get());
    }


    public function showAnswer(Survey $survey, Submission $submission)
    {

        return AnswerResource::collection($submission->answers()->get());
    }


    public function store(Survey $survey, StoreAnswerRequest $request)
    {
        $data = $request->validated();

        $submission = Submission::create([
            'survey_id' => $survey->id,
            'start_date' => date('Y-m-d H:i:s'),
            'end_date' => date('Y-m-d H:i:s')
        ]);

        foreach ($data['answers'] as $questionId => $answer)
        {

            $data = [
                'question_id' => $questionId,
                'submission_id' => $submission->id,
                'answer' => is_array($answer) ? json_encode($answer) : $answer,
            ];

            Answer::create($data);
        }

        event(new SurveySubmitted($submission));

        return response(new SubmissionResource($submission), 201);
    }
}
