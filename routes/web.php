<?php

use App\Events\SurveySubmitted;
use App\Models\Submission;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function ()
{
    return view('welcome');
});

Route::get('/event', function ()
{
    auth()->login(User::find(1));
    $s = Submission::find(1);
    event(new SurveySubmitted($s));
});
