<?php

namespace App\Rules;

use App\Models\Question;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class onlyAsDraft implements ValidationRule
{
    public function __construct(private readonly Question $question)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->question->status !== 'draft') {
            $fail('The question should be a draft to be able to edit.');
        }
    }
}
