<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WithQuestionMark implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!str_ends_with($value, '?')) {
            $fail('The :attribute should end with question mark (?).');
        }
    }
}
