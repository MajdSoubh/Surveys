<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSurveyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $survey = $this->route('survey');
        if ($survey->user_id !== $this->user()->id)
        {
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:1000',
            'image' => 'nullable|string',
            'user_id' => 'exists:users,id',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
            'expire_date' => 'nullable|after:tomorrow',
            'questions' => 'array',
            'questions.*.id' => 'required',
            'questions.*.question' => "required|string",
            'questions.*.type' => ['required', Rule::in(['text', 'textarea', 'select', 'radio', 'checkbox'])],
            'questions.*.description' => 'nullable|string',
            'questions.*.data' => 'present'


        ];
    }

    public function attributes()
    {
        return [
            'questions.*.question' => 'question',
            'questions.*.type' => 'type',
            'questions.*.description' => 'description',
            'questions.*.data' => 'data',
        ];
    }
}
