<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubmissionResource;
use App\Http\Resources\SurveyResourceDashboard;
use App\Models\Survey;
use App\Models\Submission;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Total Number of Surveys
        $totalSurveys = Survey::where('user_id', auth()->user()->id)->count();

        // Latest Survey
        $latestSurvey = Survey::where('user_id', auth()->user()->id)->latest('created_at')->withCount('answers')->first();

        // Total Answers
        $totalSubmissions = Submission::join('surveys', 'submissions.survey_id', '=', 'surveys.id')->where('user_id', auth()->user()->id)->count();

        // Latest 5 Answers
        $latestSubmission = Submission::join('surveys', 'submissions.survey_id', '=', 'surveys.id')
            ->where('user_id', auth()->user()->id)
            ->orderBy('end_date', 'desc')
            ->limit(5)->getModels('submissions.*');

        return [
            'totalSurveys' => $totalSurveys,
            'latestSurvey' => $latestSurvey ? new SurveyResourceDashboard($latestSurvey) : null,
            'totalSubmissions' => $totalSubmissions,
            'latestSubmissions' => SubmissionResource::collection($latestSubmission),

        ];
    }
}
