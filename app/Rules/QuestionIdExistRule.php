<?php

namespace App\Rules;

use App\Models\Question;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class QuestionIdExistRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if (preg_match('/^answers.(\d+)/', $attribute, $matches))
        {

            $question = Question::where('survey_id', request()->route('survey')->id)->find($matches[1]);
            if (!$question)
            {
                $fail('Question does not match survey');
            }
        }
    }
}
