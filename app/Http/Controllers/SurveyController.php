<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Http\Resources\SurveyResource;
use App\Models\Question;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth()->user();
        return SurveyResource::collection(Survey::where('user_id', $user->id)->latest()->paginate(6));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSurveyRequest $request)
    {

        $data = $request->validated();

        // Check if image was given and save to local file system
        if (isset($data['image']))
        {
            $data['image'] = $this->saveImage($data['image']);
        }

        $survey = Survey::create($data);

        // Create new Questions
        foreach ($data['questions'] as $question)
        {
            $question['survey_id'] = $survey->id;
            $this->createQuestion($question);
        }
        return new SurveyResource($survey);
    }

    /**
     * Display the specified resource.
     */
    public function show(Survey $survey)
    {
        $user = Auth()->user();
        if ($user->id !== $survey->user_id)
        {
            return abort(403, 'Unauthorized action.');
        }
        return new SurveyResource($survey);
    }

    /**
     * Display the specified resource for guest.
     */
    public function showForGuest(Survey $survey)
    {
        if (!$survey->isActive() || $survey->expired())
        {
            return response([
                'message' => 'Sorry, Survey not available now.',
                'data' => null,
            ]);
        }

        return new SurveyResource($survey);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSurveyRequest $request, Survey $survey)
    {
        $data = $request->validated();


        // Check if image was given and save to local file system
        if (isset($data['image']))
        {
            $data['image'] = $this->saveImage($data['image']);

            // If there is an old image delete it
            if ($survey->image)
            {
                $absolutePath = public_path($survey->image);
                File::delete($absolutePath);
            }
        }

        $survey->update($data);

        // Get ids of the existing questions as plain array
        $existingIds = $survey->questions()->pluck('id')->toArray();

        // Get ids of new questions as plain array
        $newIds = Arr::pluck($data['questions'], 'id');

        // Find questions to delete
        $toDelete = array_diff($existingIds, $newIds);

        // Find questions to add
        $toAdd = array_diff($newIds, $existingIds);


        // Delete questions in $toDelete variable
        Question::destroy($toDelete);

        // Create new questions
        foreach ($data['questions'] as $question)
        {
            if (in_array($question['id'], $toAdd))
            {
                $question['survey_id'] = $survey->id;
                $this->createQuestion($question);
            }
        }


        // Update existing questions
        $questionMap = collect($data['questions'])->keyBy('id');
        foreach ($survey->questions as $question)
        {
            if (isset($questionMap[$question->id]))
            {
                $this->updateQuestion($question, $questionMap[$question->id]);
            }
        }

        return new SurveyResource($survey);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Survey $survey)
    {
        $user = Auth()->user();

        // Check if user authorized to perform destroy
        if ($user->id !== $survey->user_id)
        {
            return abort(403, 'Unauthorized action.');
        }

        $survey->submissions()->delete();
        $survey->answers()->delete();
        $survey->delete();

        // If there is an image delete it
        if ($survey->image)
        {
            $absolutePath = public_path($survey->image);
            File::delete($absolutePath);
        }
        return response('', 204);
    }



    private function saveImage($image)
    {
        // Check if image valid base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $matches))
        {
            // Take out the base64 encoded text without the mime type
            $image = substr($image, strpos($image, ',') + 1);
            // Get the file extension
            $type = strtolower($matches[1]);
            // Check if the file is an image
            if (!in_array($type, ['png', 'jpeg', 'gif', 'png']))
            {
                throw new Exception('invalid image type');
            }
            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);
            if (!$image)
            {
                throw new Exception('base64 decode failed');
            }
        }
        else
        {
            throw new Exception('did not match data URI with image data');
        }
        $dir = 'images/';
        $file = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        if (!File::exists($absolutePath))
        {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $image);
        return $relativePath;
    }

    private function createQuestion($data)
    {

        // Convert question data to json
        $data['data'] = json_encode($data['data']);

        return Question::create($data);
    }

    private function updateQuestion(Question $question, $data)
    {
        // Convert question data to json
        $data['data'] = json_encode($data['data']);

        $question->update($data);
    }
}
