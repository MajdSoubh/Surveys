<?php

use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SurveyController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function ()
{
    Route::get('/user', function (Request $request)
    {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/survey', SurveyController::class);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/survey/{survey}/submissions', [SubmissionController::class, 'showSurveySubmissions']);
    Route::get('/survey/{survey}/submissions/{submission}', [SubmissionController::class, 'showAnswer'])->scopeBindings();
});


Route::get('/survey-by-slug/{survey:slug}', [SurveyController::class, 'showForGuest']);
Route::post('/survey/{survey}/answer', [SubmissionController::class, 'store']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::get('/database/migrate', function ()
{

    Artisan::call('migrate:fresh');
});
